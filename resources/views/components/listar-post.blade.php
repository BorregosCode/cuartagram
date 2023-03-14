<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"> <!-- Seccion publicaciones-->
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['post' => $post , $post->user]) }}">
                        <img src="{{asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div> <!-- Cierre Seccion publicaciones-->
            <!-- Mostrar paginacion -->
        <div>
            {{ $posts->links() }}
        </div>
    @else
        <p class=" text-center">No hay post</p>
    @endif
</div>