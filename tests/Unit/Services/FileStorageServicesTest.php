<?php

namespace Tests\Unit\Services;


use App\Services\Contract\FileStorageServicesContract;
use http\Exception\BadUrlException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageServicesTest extends TestCase
{
    protected FileStorageServicesContract $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(FileStorageServicesContract::class);
    }

    public function test_file_upload(): void
    {
        $filePath = $this->uploadedFile();
        $this->assertTrue(Storage::has($filePath));
        $this->assertEquals('public', Storage::getVisibility($filePath));
    }

    public function test_file_upload_with_additional_path()
    {
        $filePath = $this->uploadedFile(additionalPath: 'test');

        $this->assertTrue(Storage::has($filePath));
        $this->assertStringContainsString('test', $filePath);
        $this->assertEquals(Storage::getVisibility($filePath), 'public');
    }

    public function test_remove()
    {
        $filePath = $this->uploadedFile();
        $this->assertTrue(Storage::has($filePath));

        $this->service->remove($filePath);
        $this->assertFalse(Storage::has($filePath));
    }



    protected function uploadedFile($fileImage = 'image.png', $additionalPath = ''):string
    {
        $file = UploadedFile::fake()->image($fileImage);
        return $this->service->upload($file, $additionalPath);
    }
}
