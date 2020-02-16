@foreach($articles as $article)
    <div class0>
        <h5>{{ $article->title }}</h5>
        <p>{{ $article->desc }}</p>
        <p>{{ $article->date }}</p>
        <div class="text-right">
            <button class="btn btn-success">Loe uudist</button>
        </div>
        <hr style="margin-top:5px;">
    </div>
@endforeach
