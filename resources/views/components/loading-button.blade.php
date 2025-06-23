<button id="{{ $id }}" type="submit" class="buttonclas mb-3">
    <span id="spinner" class="spinner-border spinner-border-sm" style="display: none;" aria-hidden="true"></span>
    <span role="status" id="buttonText">{{ $text }}</span>
</button>

<script>
    document.querySelector('#{{ $id }}').addEventListener('click', function() {
        const btn = document.querySelector('#{{ $id }}');
        const spinner = document.querySelector('#spinner');
        const buttonText = document.querySelector('#buttonText');

        spinner.style.display = 'inline-block';
        buttonText.innerText = 'Processing...';

        btn.disabled = true;

        document.querySelector('form').submit();
    });
</script>
