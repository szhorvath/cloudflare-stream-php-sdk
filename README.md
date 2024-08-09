# Cloudflare Stream PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/szhorvath/cloudflare-stream-php-sdk.svg?style=flat-square)](https://packagist.org/packages/szhorvath/cloudflare-stream-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/szhorvath/cloudflare-stream-php-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/szhorvath/cloudflare-stream-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/szhorvath/cloudflare-stream-php-sdk.svg?style=flat-square)](https://packagist.org/packages/szhorvath/cloudflare-stream-php-sdk)

A PHP SDK for integrating and managing Cloudflare's Streaming services.

## Table of Contents

- [Cloudflare Stream PHP SDK](#cloudflare-stream-php-sdk)
  - [Table of Contents](#table-of-contents)
  - [Introduction](#introduction)
  - [Features](#features)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Testing](#testing)
  - [Changelog](#changelog)
  - [Security Vulnerabilities](#security-vulnerabilities)
  - [Credits](#credits)
  - [License](#license)

## Introduction

This SDK provides a simple and efficient way to interact with Cloudflare's Streaming API using PHP. It enables developers to easily integrate Cloudflare's video streaming capabilities into their PHP applications.

## Features

-   Upload videos to Cloudflare Stream
-   Retrieve video details
-   List all videos
-   Delete videos
-   Generate signed URLs for video playback

## Installation

You can install the SDK via Composer. Run the following command in your project directory:

```bash
composer require szhorvath/cloudflare-stream-php-sdk
```

## Usage

```php
$skeleton = new Szhorvath\StreamSdk();
echo $skeleton->echoPhrase('Hello, Szhorvath!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Sandor Horvath](https://github.com/szhorvath)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
