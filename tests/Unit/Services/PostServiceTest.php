<?php

namespace Tests\Unit\Services;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;

class PostServiceTest extends TestCase
{
    public $postMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->postMock = $this->createMock(Post::class);
    }

    public function test_store_method()
    {
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn($this->postMock);

        $result = resolve(PostService::class)->store([
            'body' => 'A new post',
        ]);

        $this->assertInstanceOf(Post::class, $result);
    }

    public function test_store_method_with_image()
    {
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn($this->postMock);

        $image = UploadedFile::fake()->image('image.png');

        $result = resolve(PostService::class)->store(
            [
                'body' => 'A new post',
            ],
            $image,
        );

        $this->assertInstanceOf(Post::class, $result);
    }

    public function test_store_method_with_incorrect_parameters()
    {
        $this->expectException('TypeError');

        resolve(PostService::class)->store('data');
    }

    public function test_update_method()
    {
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn($this->postMock);

        $result = resolve(PostService::class)->update(
            $this->postMock,
            [
                'body' => 'Updated post',
            ],
        );

        $this->assertInstanceOf(Post::class, $result);
    }

    public function test_update_method_with_image()
    {
        DB::shouldReceive('transaction')
            ->once()
            ->andReturn($this->postMock);

        $image = UploadedFile::fake()->image('image.png');

        $result = resolve(PostService::class)->update(
            $this->postMock,
            [
                'body' => 'Updated post',
            ],
            $image,
        );

        $this->assertInstanceOf(Post::class, $result);
    }

    public function test_update_method_with_incorrect_parameters()
    {
        $this->expectException('TypeError');

        resolve(PostService::class)->update('data');
    }
}
