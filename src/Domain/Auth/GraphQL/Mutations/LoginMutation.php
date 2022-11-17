<?php

declare(strict_types=1);

namespace Domain\Auth\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthenticationError;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class LoginMutation
 * @package App\GraphQL\Mutations
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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
        return Type::nonNull(GraphQL::type('AccessToken'));
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

        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $authGuard */
        $authGuard = Auth::guard('api');
        $token = $authGuard->attempt($credentials);

        if (! $token) {
            throw new AuthenticationError('Wrong Credentials');
        }

        return [
            'token_type' => 'bearer',
            'access_token' => $token,
            'expires_in' => config('jwt.ttl') * 60,
        ];
    }
}
