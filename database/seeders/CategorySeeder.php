<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getCategories() as $category) {
            Category::getCategoryOrCreate($category['name'], $category);
        }
    }

    public function getCategories(): array
    {
        return [
            ['name' => 'HTML', 'description' => 'Hypertext Markup Language (HTML) adalah bahasa markup standar untuk dokumen yang dirancang untuk ditampilkan di peramban web.'],
            ['name' => 'CSS', 'description' => 'Cascading Style Sheets (CSS) adalah bahasa stylesheet yang digunakan untuk menggambarkan presentasi dari dokumen yang ditulis dalam format HTML atau XML.'],
            ['name' => 'JavaScript', 'description' => 'JavaScript adalah bahasa skrip tingkat tinggi yang diinterpretasikan yang memungkinkan fungsionalitas interaktif dan dinamis pada situs web.'],
            ['name' => 'Database', 'description' => 'Basis data adalah kumpulan informasi atau data terstruktur yang disimpan dan diakses secara elektronik.'],
            ['name' => 'PHP', 'description' => 'PHP adalah bahasa skrip sisi server yang dirancang untuk pengembangan web, banyak digunakan untuk membuat halaman web dinamis.'],
            ['name' => 'Ruby', 'description' => 'Ruby adalah bahasa pemrograman berorientasi objek dan dinamis yang dikenal karena kesederhanaan dan produktivitasnya.'],
            ['name' => 'Design', 'description' => 'Desain mencakup penciptaan elemen visual dan fungsional untuk berkomunikasi dan memecahkan masalah.'],
            ['name' => 'Tool', 'description' => 'Alat adalah program atau aplikasi yang dirancang untuk melakukan tugas-tugas tertentu atau membantu dalam proses pengembangan.'],
            ['name' => 'Bebas', 'description' => "Bebas berarti 'bebas' dalam bahasa Indonesia, sering digunakan untuk mewakili kategori dengan berbagai konten atau bermacam-macam."],
            ['name' => 'Android', 'description' => 'Android adalah sistem operasi seluler yang dikembangkan oleh Google, yang utamanya digunakan pada smartphone dan tablet.'],
            ['name' => 'Hosting', 'description' => 'Hosting mengacu pada layanan penyediaan ruang penyimpanan dan akses untuk situs web atau aplikasi pada server.'],
            ['name' => 'Wordpress', 'description' => 'WordPress adalah sistem manajemen konten (CMS) populer yang digunakan untuk membuat dan mengelola situs web dan blog.'],
            ['name' => 'Codeigniter', 'description' => 'CodeIgniter adalah kerangka kerja PHP yang kuat yang digunakan untuk membangun aplikasi web berfitur lengkap.'],
            ['name' => 'Laravel', 'description' => 'Laravel adalah kerangka kerja PHP modern yang dikenal karena sintaks elegannya dan fitur-fitur yang kuat untuk pengembangan web.'],
            ['name' => 'jQuery', 'description' => 'jQuery adalah pustaka JavaScript cepat, ringan, dan kaya fitur yang digunakan untuk menyederhanakan scripting sisi klien.'],
            ['name' => 'Nodejs', 'description' => 'Node.js adalah lingkungan runtime yang memungkinkan eksekusi kode JavaScript di sisi server, yang memungkinkan scripting sisi server.'],
            ['name' => 'Vue', 'description' => 'Vue.js adalah kerangka kerja JavaScript progresif untuk membangun antarmuka pengguna dan aplikasi satu halaman.'],
            ['name' => 'API', 'description' => 'API (Application Programming Interface) memungkinkan berbagai aplikasi perangkat lunak berkomunikasi dan berinteraksi satu sama lain.'],
            ['name' => 'Ajax', 'description' => 'Ajax singkatan dari Asynchronous JavaScript dan XML, digunakan untuk mengirim dan mengambil data dari server tanpa harus me-reload halaman.'],
            ['name' => 'Python', 'description' => 'Python adalah bahasa pemrograman serbaguna tingkat tinggi yang dikenal karena kemudahan baca dan tingkat kejelasannya.'],
            ['name' => 'SEO', 'description' => 'SEO (Search Engine Optimization) adalah praktik mengoptimalkan konten web untuk meningkatkan visibilitasnya dalam hasil mesin pencari.'],
            ['name' => 'Slim', 'description' => 'Slim adalah kerangka kerja PHP ringan yang dirancang untuk membuat aplikasi web sederhana namun bertenaga.'],
            ['name' => 'Sharing', 'description' => 'Berbagi melibatkan distribusi atau pertukaran informasi, sumber daya, atau konten dengan orang lain.'],
            ['name' => 'Testing', 'description' => 'Testing mengacu pada proses evaluasi perangkat lunak untuk mengidentifikasi dan memperbaiki cacat atau memverifikasi fungsionalitasnya.'],
            ['name' => 'Firebase', 'description' => 'Firebase adalah platform komprehensif dari Google untuk membangun aplikasi seluler dan web dengan berbagai layanan backend.'],
            ['name' => 'Responsive', 'description' => 'Desain responsif memastikan bahwa sebuah situs web dapat menyesuaikan dan tampil bagus pada berbagai perangkat dan ukuran layar.'],
            ['name' => 'Progressive Web App', 'description' => 'Progressive Web Apps (PWA) adalah aplikasi web yang menawarkan pengalaman seperti aplikasi asli pada berbagai perangkat.'],
            ['name' => 'Flask', 'description' => 'Flask adalah kerangka kerja Python ringan untuk membangun aplikasi web dengan kesederhanaan dan kemampuan pengembangan.'],
            ['name' => 'Django', 'description' => 'Django adalah kerangka kerja web Python tingkat tinggi yang mendorong pengembangan cepat dan desain bersih.'],
            ['name' => 'Reactjs', 'description' => 'React.js adalah pustaka JavaScript populer untuk membangun antarmuka pengguna dengan pendekatan berbasis komponen.'],
            ['name' => 'Nuxtjs', 'description' => 'Nuxt.js adalah kerangka kerja untuk membuat aplikasi Vue.js universal dengan rendering sisi server dan fitur-fitur lainnya.'],
            ['name' => 'Vuex', 'description' => 'Vuex adalah pola manajemen state dan perpustakaan yang digunakan dengan aplikasi Vue.js untuk mengelola state aplikasi.'],
            ['name' => 'Redux', 'description' => 'Redux adalah kontainer state yang dapat diprediksi untuk aplikasi JavaScript, umumnya digunakan dengan aplikasi React.'],
            ['name' => 'Nextjs', 'description' => 'Next.js adalah kerangka kerja React untuk membangun situs dengan rendering sisi server (SSR) dan situs statis.'],
            ['name' => 'GrapHQL', 'description' => 'GraphQL adalah bahasa dan runtime kueri untuk API, memungkinkan klien meminta hanya data yang dibutuhkan.'],
            ['name' => 'GO', 'description' => 'Go (sering disebut Golang) adalah bahasa pemrograman sumber terbuka yang dikembangkan oleh Google.'],
            ['name' => 'Flutter', 'description' => 'Flutter adalah kit pengembangan perangkat lunak UI sumber terbuka (SDK) untuk membangun aplikasi terkompilasi secara native untuk perangkat seluler, web, dan desktop dari satu kode sumber.'],
            ['name' => 'Kotlin', 'description' => 'Kotlin adalah bahasa pemrograman modern yang tipe statis yang digunakan untuk mengembangkan aplikasi Android dan aplikasi lainnya.'],
            ['name' => 'SQLite', 'description' => 'SQLite adalah mesin basis data ringan dan populer yang mandiri dan tidak memerlukan server, digunakan dalam berbagai aplikasi dan perangkat.'],
            ['name' => 'Mysql', 'description' => 'MySQL adalah sistem manajemen basis data relasional (RDBMS) sumber terbuka yang banyak digunakan untuk aplikasi web.'],
            ['name' => 'Hugo', 'description' => 'Hugo adalah pembangkit situs statis yang cepat dan fleksibel yang dibangun dengan Go, cocok untuk membuat blog dan situs web.'],
            ['name' => 'Static site', 'description' => 'Situs statis mengacu pada situs web yang terdiri dari konten tetap dan tidak dihasilkan secara dinamis.'],
            ['name' => 'Alpinejs', 'description' => 'Alpine.js adalah kerangka kerja JavaScript ringan untuk membangun antarmuka web dengan pengaturan minimal.'],
            ['name' => 'Tailwindcss', 'description' => 'Tailwind CSS adalah kerangka kerja CSS berbasis utilitas yang menyediakan sekumpulan kelas utilitas tingkat rendah untuk membangun desain kustom dengan cepat.'],
            ['name' => 'Laravel Livewire', 'description' => 'Laravel Livewire adalah kerangka kerja full-stack untuk membangun antarmuka web dinamis tanpa perlu menulis JavaScript.'],
            ['name' => 'Dart', 'description' => 'Dart adalah bahasa pemrograman yang dikembangkan oleh Google, yang utamanya digunakan bersama dengan kerangka kerja Flutter.'],
        ];
    }
}
