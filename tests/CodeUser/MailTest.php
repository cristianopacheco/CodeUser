<?php

namespace CodePress\CodeUser\Tests\Repository;

use CodePress\CodeUser\Repository\RoleRepositoryInterface;
use CodePress\CodeUser\Repository\UserRepositoryEloquent;
use CodePress\CodeUser\Tests\AbstractMailTestCase;
use Illuminate\Support\Facades\Hash;
use Mockery as m;

class MailTest extends AbstractMailTestCase
{
    /**
     * @var UserRepositoryEloquent
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();
        $this->migrate();
        $roleRepositoryMock = m::mock(RoleRepositoryInterface::class);
        $this->repository = new UserRepositoryEloquent($roleRepositoryMock);
    }

    public function test_can_create_user()
    {
        $user = $this->repository->create([
            'name' => 'Teste',
            'email' => 'teste@teste.com',
            'password' => '123456'
        ]);

        $this->assertEquals('Teste', $user->name);
        $this->assertEquals('teste@teste.com', $user->email);
        $this->assertTrue(Hash::check('123456', $user->password));
    }
}