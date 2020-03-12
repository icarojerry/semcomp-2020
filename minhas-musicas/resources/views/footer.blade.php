<footer class="footer py-5">
    <hr/>
    <div class="container">
		<p  class="text-center color-primary">
			Músicas obtidas através do site <a class="color-second" href="https://www.letras.mus.br/"><b>LETRAS.MUS.BR - Letras de músicas</b></a>.
		</p>
	</div>
    @if(!app()->environment('production') && $tempoExecucao)
        <div class="bg-info panel">
            <p class="text-center">
                A página levou {{ $tempoExecucao }} segundos para abrir.
                <br/>
                <small>(Está mensagem só aparece em modo debug).</small>
            </p>
        </div>
    @endif
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@yield('scripts')
