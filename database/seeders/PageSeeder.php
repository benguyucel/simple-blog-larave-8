<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages  = ['Hakkımızda', 'Kariyer', 'Vizyon', 'Misyon'];
        $count = 0;
        foreach ($pages as $page) {
            $count++;
            DB::table('pages')->insert([
                'title' => $page,
                'slug' => Str::slug($page),
                'image'=>'https://wallpaper-mania.com/wp-content/uploads/2018/09/High_resolution_wallpaper_background_ID_77701372504.jpg',
                'content' => "
                inelenen bir sayfa içeriğinin okuyucunun dikkatini dağıttığı bilinen bir gerçektir. 
                Lorem Ipsum kullanmanın amacı, sürekli 'buraya metin gelecek, buraya metin gelecek'
                 yazmaya kıyasla daha dengeli bir harf dağılımı sağlayarak okunurluğu artırmasıdır. 
                 Şu anda birçok masaüstü yayıncılık paketi ve web sayfa düzenleyicisi, 
                 varsayılan mıgır metinler olarak Lorem Ipsum kullanmaktadır. Ayrıca arama motorlarında
                  'lorem ipsum' anahtar sözcükleri ile arama yapıldığında henüz tasarım aşamasında olan
                   çok sayıda site listelenir.
                 Yıllar içinde, bazen kazara, bazen bilinçli olarak (örneğin mizah katılarak), çeşitli
                  sürümleri geliştirilmiştir.",
                'order' => $count,
                'created_at' => now(),
                'updated_at' => now()

            ]);
        }
    }
}
