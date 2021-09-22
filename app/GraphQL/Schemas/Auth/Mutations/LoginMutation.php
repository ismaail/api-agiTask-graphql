<?php

declare(strict_types=1);

namespace App\GraphQL\Schemas\Auth\Mutations;

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
     * @var string[]
     */
    protected $attributes = [
        'name' => 'login',
        'description' => 'User Login - returns JWT Access Token',
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('AccessToken'));
    }

    /**
     * @return array[]
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
     * @param $root
     * @param $args
     *
     * @return array
     *
     * @throws \App\Exceptions\AuthenticationError If Wrong Credentials.
     */
    public function resolve($root, $args): array
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
