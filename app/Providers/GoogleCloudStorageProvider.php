<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;
use Superbalist\LaravelGoogleCloudStorage\GoogleCloudStorageServiceProvider;

class GoogleCloudStorageProvider extends GoogleCloudStorageServiceProvider
{
  public function boot()
  {
    $factory = $this->app->make('filesystem');
    $factory->extend('gcs', function ($app, $config) {
      $storage = app('firebase.storage');
      $storageClient = $storage->getStorageClient();
      $bucket = $storage->getBucket();
      $pathPrefix = Arr::get($config, 'path_prefix');
      $storageApiUri = Arr::get($config, 'storage_api_uri');
      $adapter = new GoogleStorageAdapter($storageClient, $bucket, $pathPrefix, $storageApiUri);
      return $this->createFilesystem($adapter, $config);
    });
  }
}
