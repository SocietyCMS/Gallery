<?php

namespace Modules\Gallery\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Gallery\Entities\Album;
use Modules\Gallery\Entities\Photo;
use Modules\Menu\Entities\Menu;
use Symfony\Component\Console\Helper\ProgressBar;

class DemoTableSeeder extends Seeder
{

    protected $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('gallery__albums')->delete();
        DB::table('gallery__photos')->delete();

        $this->faker = Factory::create();

        $this->createAlbum('Cats');
        $this->createAlbum('Food');
        $this->createAlbum('City');
        $this->createAlbum('Abstract');
        $this->createAlbum('People');
        $this->createAlbum('Nightlife');

        $this->createMenuEntry();
    }

    /**
     * @param $AlbumCategory
     * @return static
     */
    private function createAlbum($AlbumCategory)
    {
        $Album = Album::create([
            'title' => $AlbumCategory,
            'slug' => Str::slug($AlbumCategory),
            'published' => true
        ]);

        $faker = Factory::create();
        $activity = $Album->activities->first();
        $activity->update([
            'created_at' => $start = $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeBetween($start),
        ]);

        $this->createPhotos($Album, $AlbumCategory);
        return $Album;
    }

    /**
     * @param $Album
     * @param $AlbumCategory
     * @internal param $catsAlbum
     */
    private function createPhotos($Album, $AlbumCategory)
    {
        $photosCount = $this->faker->numberBetween($min = 15, $max = 30);

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $progress = new ProgressBar($output, $photosCount);

        for ($x = 0; $x <= $photosCount; $x++) {
            $photo = Photo::create([
                'album_id' => $Album->id,
                'title' => $this->faker->words(6, true),
                'caption' => $this->faker->sentence(),
                'captured_at' => \Carbon\Carbon::now(),
            ]);

            list($dimensionX, $dimensionY) = $this->faker->randomElement([
                [1920, 1200],
                [1920, 1080],
                [1600, 1200],
                [1280, 1024],
                [1280, 800],
                [960, 720],
            ]);
            $image = $this->faker->image('/tmp', $dimensionX, $dimensionY, strtolower($AlbumCategory));
            $photo->addMedia($image)->toCollection('images');

            $progress->advance();
        }

        $progress->finish();
    }

    /**
     *
     */
    private function createMenuEntry()
    {
        if ($main = Menu::root()->where(['name' => 'Main'])->first()) {
            $main->children()->create(['name' => 'Gallery', 'url' => 'gallery', 'active' => true]);
        }
    }
}
