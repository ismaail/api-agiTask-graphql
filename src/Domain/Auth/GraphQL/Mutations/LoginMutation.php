<?php

declare(strict_types=1);

namespace Domain\Auth\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthenticationError;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @phpcs:disable Generic.Files.LineLength.TooLong
 */
class LoginMutation extends Mutation
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'login',
        'description' => 'User Login - returns JWT Access Token',
    ];

    public function type(): Type
    {
        return GraphQL::type('AccessToken');
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['email'],
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['min:8'],
            ],
        ];
    }

    /**
     * @param mixed $root
     * @param array $args
     *
     * @return array{token_type: string, access_token: string, expires_in: int}
     *
     * @throws \App\Exceptions\AuthenticationError If Wrong Credentials.
     */
    public function resolve(mixed $root, array $args): array
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];

        if (! Auth::guard('web')->attempt($credentials)) {
            throw new AuthenticationError('Wrong Credentials');
        }

        /** @var \Domain\User\Models\User $user */
        $user = Auth::user();
        $user->load('tokens');

        $token = $user->createToken(config('app.name') . ' Password Grant Client');

        return [
            'user_id' => $user->id,
            'token_type' => 'Bearer',
            'access_token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at,
        ];
    }
}
