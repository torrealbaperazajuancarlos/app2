<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Fixed reader testimonials displayed on the home page.
     *
     * @var array<int, array{title: string, quote: string, reader: string}>
     */
    private const TESTIMONIALS = [
        [
            'title' => 'Mi biblioteca, siempre conmigo',
            'quote' => 'Gracias a los PDF puedo llevar mis libros favoritos a todas partes y retomar la lectura justo donde la dejé.',
            'reader' => 'Lucía Fernández',
        ],
        [
            'title' => 'Leer sin esperas',
            'quote' => 'Descargar el PDF y empezar a leer al instante cambió por completo mi forma de descubrir nuevos autores.',
            'reader' => 'Andrés Ramírez',
        ],
        [
            'title' => 'Lecturas que se adaptan a mí',
            'quote' => 'Puedo ajustar el tamaño de la letra y leer de noche desde cualquier dispositivo sin cansar la vista.',
            'reader' => 'Valentina Suárez',
        ],
        [
            'title' => 'Una colección que crece conmigo',
            'quote' => 'Cada mes descubro títulos nuevos que se ajustan a mis gustos y siempre tengo algo pendiente en la lista.',
            'reader' => 'Marta Delgado',
        ],
        [
            'title' => 'Perfecto para viajar ligero',
            'quote' => 'Ya no cargo varios libros en la maleta: toda mi biblioteca cabe en el móvil y me acompaña en cada viaje.',
            'reader' => 'Diego Herrera',
        ],
        [
            'title' => 'Recuperé el hábito de leer',
            'quote' => 'Con las recomendaciones de la web volví a leer todas las noches, algo que había dejado de lado hace años.',
            'reader' => 'Carmen Ortiz',
        ],
        [
            'title' => 'Autores que no conocía',
            'quote' => 'Gracias a las categorías encontré voces nuevas que jamás habría descubierto en una librería tradicional.',
            'reader' => 'Pablo Méndez',
        ],
        [
            'title' => 'Ideal para leer en familia',
            'quote' => 'Los fines de semana elegimos un libro entre todos y lo leemos en voz alta desde la tablet. Es nuestro nuevo plan.',
            'reader' => 'Elena Navarro',
        ],
        [
            'title' => 'Sin ocupar espacio en casa',
            'quote' => 'Tengo cientos de lecturas guardadas y ninguna estantería más en el salón. La colección digital fue un acierto.',
            'reader' => 'Javier Castro',
        ],
        [
            'title' => 'La mejor opción para estudiar',
            'quote' => 'Puedo subrayar, buscar palabras y volver a mis apuntes en segundos justo antes de un examen.',
            'reader' => 'Sofía Romero',
        ],
        [
            'title' => 'Lecturas para cada momento',
            'quote' => 'Si quiero algo corto para el metro o una novela larga para el sofá, siempre encuentro la opción perfecta.',
            'reader' => 'Ricardo Peña',
        ],
    ];

    /**
     * Display the public home page.
     */
    public function __invoke(): View
    {
        $books = Book::query()
            ->with(['author', 'category'])
            ->orderBy('title')
            ->orderBy('id')
            ->take(3)
            ->get();

        $featuredBooks = $books->isEmpty()
            ? $books
            : collect([0, 1, 2])->map(
                fn (int $index): Book => $books[$index % $books->count()]
            );

        return view('front.home', [
            'featuredBooks' => $featuredBooks,
            'testimonials' => self::TESTIMONIALS,
            'categories' => Category::query()->withCount('books')->orderBy('name')->get(),
            'authors' => Author::query()->orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }
}
