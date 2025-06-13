<?php

namespace App\Controller;

use App\Helper\ValidatorHelper;
use App\Interface\UserServiceInterface;
use App\Model\Filter\User\TaskListFilter;
use App\Model\Request\User\TaskCreateRequest;
use App\Model\Request\User\TaskUpdateRequest;
use App\Model\Request\User\UserCreateRequest;
use App\Model\Request\User\UserUpdateRequest;
use App\Model\Response\User\UserCreateResponse;
use App\Model\Response\User\UserItemResponse;
use App\Model\Response\User\UserUpdateResponse;
use App\Service\EmailService;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;
use Throwable;

#[OA\Response(
    response: 500,
    description: 'Внутренняя ошибка сервера'
)]
#[Route("/user")]
class UserController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorHelper $validatorHelper,
        private readonly UserServiceInterface $userService,
        private readonly EmailService $emailService,
    ) {
    }

    #[OA\Tag(name: 'Пользователи')]
    #[OA\Post(
        description: 'Метод создает нового пользователя на основе переданных данных.',
        summary: 'Создание нового пользователя'
    )]
    #[OA\RequestBody(
        description: 'Параметры запроса', content: new Model(type: UserCreateRequest::class)
    )]
    #[OA\Response(
        response: 201,
        description: 'Пользователь успешно создана',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'token', description: 'JWT токен', type: 'string'),
                new OA\Property(property: 'refresh_token', description: 'Токен для обновления', type: 'string')
            ],
            type: 'object'
        )
    )]
    #[Route('', name: 'user_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Нет доступа к созданию пользователей!');

        $result = [];
        $statusCode = Response::HTTP_CREATED;
        try {
            $content = $request->getContent();
            $data = $this->serializer->deserialize($content, UserCreateRequest::class, 'json');
            $this->validatorHelper->validate($data);
            $result = $this->userService->create($data);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Пользователи')]
    #[OA\Put(
        description: 'Этот метод редактирует пользователя на основе переданных данных.',
        summary: 'Редактирование пользователя'
    )]
    #[OA\RequestBody(
        description: 'Параметры запроса', content: new Model(type: UserUpdateRequest::class)
    )]
    #[OA\Response(
        response: 200,
        description: 'Пользователь успешно отредактирован',
        content: new Model(type: UserUpdateResponse::class)
    )]
    #[Route('/{id}', name: 'user_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Нет доступа к созданию пользователей!');

        $result = [];
        $statusCode = Response::HTTP_OK;
        try {
            $content = $request->getContent();
            $data = $this->serializer->deserialize($content, UserUpdateRequest::class, 'json');
            $this->validatorHelper->validate($data);
            $this->userService->create($data);
            $result = $this->userService->update($data, $id);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Пользователи')]
    #[OA\Delete(
        description: 'Метод удаляет пользователя на основе переданных данных.',
        summary: 'Редактирование пользователя'
    )]
    #[OA\Response(
        response: 200,
        description: 'Пользователь успешно удалён',
        content: null
    )]
    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $result = [];
        $statusCode = Response::HTTP_NO_CONTENT;
        try {
            $this->userService->delete($id);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Пользователи')]
    #[OA\Get(
        description: 'Метод получает список пользователей на основе переданных данных.',
        summary: 'Получение списка пользователей'
    )]
    #[OA\Response(
        response: 200,
        description: 'Список пользователей успешно получен',
        content: null
    )]
    #[Route('', name: 'user_list', methods: ['GET'])]
    public function getList(Request $request): JsonResponse
    {
        $result = [];
        $statusCode = Response::HTTP_OK;
        try {
            $content = $request->getContent();
            $filter = $this->serializer->deserialize($content, TaskListFilter::class, 'json');
            $this->validatorHelper->validate($filter);
            $result = $this->userService->getList($filter);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Пользователи')]
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
            $result = $this->userService->getById($id);
        } catch (Throwable $exception) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['error'] = $exception->getMessage();

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            }
        }

        return $this->json($result, $statusCode);
    }

    #[OA\Tag(name: 'Пользователи')]
    #[OA\Get(
        description: 'Отправить код подтверждения',
        summary: 'Отправить код подтверждения'
    )]
    #[Route('/send-code/{email}', name: 'user_send_code', methods: ['POST'])]
    public function sendCodeAction(string $email): Response
    {
        $result = [];
        $statusCode = Response::HTTP_OK;
        try {
            $this->emailService->sendVerificationCode($email);
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
