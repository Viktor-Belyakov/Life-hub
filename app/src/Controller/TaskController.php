<?php

namespace App\Controller;

use App\Helper\ValidatorHelper;
use App\Interface\TaskServiceInterface;
use App\Model\Filter\Task\TaskListFilter;
use App\Model\Request\Task\TaskCreateRequest;
use App\Model\Request\Task\TaskUpdateRequest;
use App\Model\Response\Task\TaskCreateResponse;
use App\Model\Response\User\UserItemResponse;
use App\Model\Response\User\UserUpdateResponse;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

#[OA\Response(
    response: 500,
    description: 'Внутренняя ошибка сервера'
)]
#[Route("/task")]
class TaskController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorHelper $validatorHelper,
        private readonly TaskServiceInterface $taskService
    ) {
    }

    #[OA\Tag(name: 'Задачи')]
    #[OA\Post(
        description: 'Метод создает новую задачу на основе переданных данных.',
        summary: 'Создание новой задачи'
    )]
    #[OA\RequestBody(
        description: 'Параметры запроса', content: new Model(type: TaskCreateRequest::class)
    )]
    #[OA\Response(
        response: 201,
        description: 'Задача успешно создана',
        content: new Model(type: TaskCreateResponse::class)
    )]
    #[Route('', name: 'task_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Нет доступа к созданию задачи!');

        $result = [];
        $statusCode = Response::HTTP_CREATED;
        try {
            $content = $request->getContent();
            /** @var TaskCreateRequest $data */
            $data = $this->serializer->deserialize($content, TaskCreateRequest::class, 'json');
            if (empty($data->getAssignedTo())) {
                $data->setAssignedTo($this->getUser()->getId());
            }
            $this->validatorHelper->validate($data);
            $result = $this->taskService->create($data);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Задачи')]
    #[OA\Put(
        description: 'Этот метод редактирует задачу на основе переданных данных.',
        summary: 'Редактирование задачи'
    )]
    #[OA\RequestBody(
        description: 'Параметры запроса', content: new Model(type: TaskUpdateRequest::class)
    )]
    #[OA\Response(
        response: 200,
        description: 'Задача успешно отредактирована',
        content: new Model(type: UserUpdateResponse::class)
    )]
    #[Route('/{id}', name: 'task_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Нет доступа к редактированию задачи!');

        $result = [];
        $statusCode = Response::HTTP_OK;
        try {
            $content = $request->getContent();
            /** @var TaskUpdateRequest $data */
            $data = $this->serializer->deserialize($content, TaskUpdateRequest::class, 'json');
            if (empty($data->getAssignedTo())) {
                $data->setAssignedTo($this->getUser()->getId());
            }
            $this->validatorHelper->validate($data);
            $result = $this->taskService->update($data, $id);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Задачи')]
    #[OA\Delete(
        description: 'Метод удаляет задачу на основе переданных данных.',
        summary: 'Удаление задачи'
    )]
    #[OA\Response(
        response: 200,
        description: 'Задача успешно удалена',
        content: null
    )]
    #[Route('/{id}', name: 'task_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $result = [];
        $statusCode = Response::HTTP_NO_CONTENT;
        try {
            $this->taskService->delete($id);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Задачи')]
    #[OA\Get(
        description: 'Метод получает список задач на основе переданных данных.',
        summary: 'Получение списка задач'
    )]
    #[OA\Response(
        response: 200,
        description: 'Список задач успешно получен',
        content: null
    )]
    #[Route('', name: 'task_list', methods: ['GET'])]
    public function getList(Request $request): JsonResponse
    {
        $result = [];
        $statusCode = Response::HTTP_OK;
        try {
            $content = $request->getContent();
            /** @var TaskListFilter $filter */
            $filter = $this->serializer->deserialize($content, TaskListFilter::class, 'json');
            $this->validatorHelper->validate($filter);
            $result = $this->taskService->getList($filter);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Задачи')]
    #[OA\Get(
        description: 'Метод получает пользователя по идентификатору.',
        summary: 'Получить пользователя'
    )]
    #[OA\Response(
        response: 200,
        description: 'Пользователь успешно получен',
        content: new Model(type: UserItemResponse::class)
    )]
    #[Route('/{id}', name: 'user_get', methods: ['GET'])]
    public function getOne(int $id): JsonResponse
    {
        $result = [];
        $statusCode = Response::HTTP_OK;
        try {
            $result = $this->taskService->getById($id);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }
}