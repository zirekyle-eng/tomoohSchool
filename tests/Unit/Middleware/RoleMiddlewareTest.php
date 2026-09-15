<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    public function test_teacher_can_access_routes_with_multiple_allowed_roles(): void
    {
        $request = Request::create('/recordings');
        $request->setUserResolver(fn (): User => new User(['role' => 'teacher']));

        $response = (new RoleMiddleware)->handle($request, fn (): Response => new Response('ok'), 'student', 'teacher');

        $this->assertSame(200, $response->getStatusCode());
    }

    public function test_unlisted_role_is_forbidden(): void
    {
        $request = Request::create('/recordings');
        $request->setUserResolver(fn (): User => new User(['role' => 'admin']));

        $this->expectException(HttpException::class);

        (new RoleMiddleware)->handle($request, fn (): Response => new Response('ok'), 'student', 'teacher');
    }
}
