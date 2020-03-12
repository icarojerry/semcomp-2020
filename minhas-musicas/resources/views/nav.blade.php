 <nav class="navbar navbar-expand-lg navbar-custom fixed-top bg-sencond">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">minhasmusicas.com</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/artistas') }}">Artistas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/musicas') }}">Músicas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/compositores') }}">Compositores</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

