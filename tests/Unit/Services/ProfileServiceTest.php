<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Mockery;
use PHPUnit\Framework\TestCase;
use App\Services\ProfileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProfileServiceTest extends TestCase
{
    public $userMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->userMock = Mockery::mock(User::class);
    }

    public function test_update_method()
    {
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn($this->userMock);

        $result = resolve(ProfileService::class)->update([
            'name' => 'Robert bruce',
            'username' => 'robert_bruce',
            'email' => 'robert@test.io',
            'bio' => 'I am robert bruce.',
        ]);

        $this->assertInstanceOf(User::class, $result);
    }

    public function test_update_method_with_image()
    {
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn($this->userMock);

        $image = UploadedFile::fake()->image('image.png');

        $result = resolve(ProfileService::class)->update(
            [
                'name' => 'Robert bruce',
                'username' => 'robert_bruce',
                'email' => 'robert@test.io',
                'bio' => 'I am robert bruce.',
            ],
            $image,
        );

        $this->assertInstanceOf(User::class, $result);
    }

    public function test_update_method_with_incorrect_parameters()
    {
        $this->expectException('TypeError');

        resolve(ProfileService::class)->update('data');
    }
}
