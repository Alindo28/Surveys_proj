<?php

namespace App\Console\Commands;

use App\Models\ContextBlock;
use Illuminate\Console\Command;

class UpdateImageUrls extends Command
{
    protected $signature = 'update:image-urls';

    protected $description = 'Update image URLs';

    public function handle()
    {
        foreach(ContextBlock::where('type', 'image')->get() as $block){

            $block->value = "https://loremflickr.com/700/400/" . fake()->word();

            $block->save();
        }

        $this->info('Image URLs updated.');
    }
}
