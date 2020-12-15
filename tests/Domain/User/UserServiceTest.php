<?php

declare(strict_types=1);


namespace Tests\Domain;

use App\App\Infra\Repositories\User\PostRepository;
use App\App\Infra\ResponseCode;
use App\Domain\DomainBlogException;
use App\Domain\DTOs\CreateUserDTO;
use App\Domain\UserService;
use App\Domain\VOs\DisplayNameVo;
use App\Domain\VOs\EmailVo;
use App\Domain\VOs\PasswordVo;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testSaveAnExistsUserShouldThrowException()
    {
        $this->expectException(DomainBlogException::class);

        /**
         * @var $userRepository PostRepository
         */
        $userRepository = $this->getMockBuilder(PostRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userRepository->method('findUserByEmail')->willReturn(
            json_decode('{
              "id": "1",
              "display_name": "asdaddsa",
              "email": "gui@email.com",
              "image": ""
            }', true)
        );

        $userService = new UserService($userRepository);

        $userService->save(
            new CreateUserDTO(
                new DisplayNameVo('Guilherme'),
                new EmailVo('gui@email.com'),
                new PasswordVo('123mudar'),
                'http://fotos.com/gui.png'
            )
        );
    }

    public function testSaveUser()
    {
        /**
         * @var $userRepository PostRepository
         */
        $userRepository = $this->getMockBuilder(PostRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userRepository->method('findUserByEmail')->willReturn([]);

        $userService = new UserService($userRepository);

        $token = $userService->save(
            new CreateUserDTO(
                new DisplayNameVo('Guilherme'),
                new EmailVo('gui@email.com'),
                new PasswordVo('123mudar'),
                'http://fotos.com/gui.png'
            )
        );

        $this->assertTrue(is_string($token));
    }

    public function testFindUsersOnEmptyDbShouldThrowExceptionAnd404Code()
    {
        $this->expectException(DomainBlogException::class);
        $this->expectExceptionCode(ResponseCode::HTTP_NOT_FOUND);
        $this->expectExceptionMessage('Users not found');
        /**
         * @var $userRepository PostRepository
         */
        $userRepository = $this->getMockBuilder(PostRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userRepository->method('findAll')->willReturn([]);

        $userService = new UserService($userRepository);

        $userService->findAll();
    }

    public function testFindUserByIdShouldThrowExceptionAnd404Code()
    {
        $this->expectException(DomainBlogException::class);
        $this->expectExceptionCode(ResponseCode::HTTP_NOT_FOUND);
        $this->expectExceptionMessage('Users not found');
        /**
         * @var $userRepository PostRepository
         */
        $userRepository = $this->getMockBuilder(PostRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userRepository->method('findById')->willReturn([]);

        $userService = new UserService($userRepository);

        $userService->findById(123);
    }

    public function testFindUserByIdShouldReturnArray()
    {
        /**
         * @var $userRepository PostRepository
         */
        $userRepository = $this->getMockBuilder(PostRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userRepository->method('findById')->willReturn(['displayName' => 'Guilherme']);

        $userService = new UserService($userRepository);

        $users = $userService->findAll();

        $this->assertIsArray($users);
    }

    public function testFindUsersShouldReturnArray()
    {
        /**
         * @var $userRepository PostRepository
         */
        $userRepository = $this->getMockBuilder(PostRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userRepository->method('findAll')->willReturn([
            [
                'displayName' => 'Guilherme'
            ],
            [
                'displayName' => 'José'
            ]
        ]);

        $userService = new UserService($userRepository);

        $users = $userService->findAll();

        $this->assertIsArray($users);
    }
}
