@component('mail::message')
Halo, MiniTutor yang baik!  
Terima kasih sudah memberikan kontribusi yang konkret terhadap pendidikan gratis Indonesia! Konten kamu yang berjudul **{{ $title }}** sudah terbit lho!

@component('mail::button', ['url' => route('post.show', $slug)])
Lihat Konten
@endcomponent

Profil kamu sebagai MiniTutor di AjarBelajar:
[https://www.ajarbelajar.com/{{'@' . $username}}](https://www.ajarbelajar.com/{{'@' . $username}})

Daftar video yang sudah diterima:
[ajarbelajar.com/dashboard/minitutor/accepted](ajarbelajar.com/dashboard/minitutor/accepted)

Untuk upload konten berikutnya:
[ajarbelajar.com/dashboard/minitutor/videos](ajarbelajar.com/dashboard/minitutor/videos)
[ajarbelajar.com/dashboard/minitutor/articles](ajarbelajar.com/dashboard/minitutor/articles)

Untuk melihat daftar feedback kontruktif yang kamu terima di setiap kontenmu:
[ajarbelajar.com/dashboard/minitutor/reviews](ajarbelajar.com/dashboard/minitutor/reviews)

Daftar Konten AjarBelajar yang boleh banget kamu share:
[bit.ly/DaftarKontenAjarBelajar](bit.ly/DaftarKontenAjarBelajar)

Kami juga meminta bantuanmu untuk promosi kontenmu yang sudah terbit, di media sosial pribadimu dan bantu #viralkanAjarBelajar untuk #pendidikangratis karena tanpa bantuanmu, kami mati gaya :(  
Terima kasih yaaa!

Salam berbagi,  
AjarBelajar  
Belajar, Berbagi, Berkontribusi

@endcomponent