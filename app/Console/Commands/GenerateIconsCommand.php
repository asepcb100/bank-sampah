<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateIconsCommand extends Command
{
    protected $signature = 'app:generate-icons
                            {--source= : Path to source logo (default: public/img/logo.png)}
                            {--no-ico : Skip generating favicon.ico}';

    protected $description = 'Generate PWA icons, favicons, and apple-touch-icon from logo.png';

    private array $sizes = [
        'icon-192x192.png' => 192,
        'icon-512x512.png' => 512,
        'apple-touch-icon.png' => 180,
        'favicon-180x180.png' => 180,
        'favicon-32x32.png' => 32,
        'favicon-16x16.png' => 16,
    ];

    public function handle(): int
    {
        $source = $this->option('source') ?? public_path('img/logo.png');

        if (! file_exists($source)) {
            $this->error("Source logo not found: {$source}");

            return static::FAILURE;
        }

        $srcImage = @imagecreatefrompng($source);

        if (! $srcImage) {
            $this->error('Failed to read source image. Ensure it is a valid PNG file.');

            return static::FAILURE;
        }

        $srcWidth = imagesx($srcImage);
        $srcHeight = imagesy($srcImage);

        $this->info("Source: {$source} ({$srcWidth}x{$srcHeight})");
        $this->newLine();

        $generated = [];

        foreach ($this->sizes as $filename => $size) {
            $destPath = public_path($filename);

            $this->generateIcon($srcImage, $srcWidth, $srcHeight, $size, $size, $destPath);

            $generated[] = $filename;
            $this->info("  ✓ {$filename} ({$size}x{$size})");
        }

        if (! $this->option('no-ico')) {
            $this->generateFaviconIco($srcImage, $srcWidth, $srcHeight);
            $generated[] = 'favicon.ico';
            $this->info('  ✓ favicon.ico (16, 32, 48)');
        }

        imagedestroy($srcImage);

        $this->newLine();
        $this->info("Generated " . count($generated) . " icon(s). Don't forget to bump the service worker cache version in sw.js");

        return static::SUCCESS;
    }

    private function generateIcon(
        \GdImage $src,
        int $srcWidth,
        int $srcHeight,
        int $destWidth,
        int $destHeight,
        string $destPath,
    ): void {
        $dest = imagecreatetruecolor($destWidth, $destHeight);
        imagealphablending($dest, false);
        imagesavealpha($dest, true);

        $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
        imagefilledrectangle($dest, 0, 0, $destWidth - 1, $destHeight - 1, $transparent);

        imagecopyresampled(
            $dest,
            $src,
            0,
            0,
            0,
            0,
            $destWidth,
            $destHeight,
            $srcWidth,
            $srcHeight,
        );

        imagepng($dest, $destPath);
        imagedestroy($dest);
    }

    private function generateFaviconIco(
        \GdImage $src,
        int $srcWidth,
        int $srcHeight,
    ): void {
        $sizes = [16, 32, 48];
        $images = [];

        foreach ($sizes as $size) {
            $dest = imagecreatetruecolor($size, $size);
            imagealphablending($dest, false);
            imagesavealpha($dest, true);

            $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
            imagefilledrectangle($dest, 0, 0, $size - 1, $size - 1, $transparent);

            imagecopyresampled($dest, $src, 0, 0, 0, 0, $size, $size, $srcWidth, $srcHeight);

            ob_start();
            imagepng($dest);
            $images[$size] = ob_get_clean();
            imagedestroy($dest);
        }

        $directoryCount = count($sizes);
        $headerSize = 6;
        $directoryEntrySize = 16;
        $directorySize = $headerSize + ($directoryEntrySize * $directoryCount);

        $offset = $directorySize;
        $data = '';

        $directory = pack(
            'vvv',
            0, // Reserved
            1, // Type: ICO
            $directoryCount,
        );

        foreach ($sizes as $size) {
            $imageData = $images[$size];
            $dataOffset = $offset;

            $directory .= pack(
                'CCCCvvVV',
                $size > 255 ? 0 : $size, // Width
                $size > 255 ? 0 : $size, // Height
                0, // Color palette
                0, // Reserved
                1, // Color planes
                32, // Bits per pixel
                strlen($imageData), // Image data size
                $dataOffset, // Image data offset
            );

            $data .= $imageData;
            $offset += strlen($imageData);
        }

        file_put_contents(public_path('favicon.ico'), $directory . $data);
    }
}
