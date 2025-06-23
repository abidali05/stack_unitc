@php
    use Illuminate\Support\Str;
@endphp
@forelse($emails as $email)
    <tr>
        {{-- <td style="padding: 5px 10px 5px 16px"><input type="checkbox"></td> --}}
        <td style="padding: 5px 10px 5px 16px">
            <svg class="star-toggle" data-id="{{ $email->id }}" fill="{{ $email->is_starred ? 'yellow' : 'none' }}" width="15" height="19" viewBox="0 0 20 19"
                xmlns="http://www.w3.org/2000/svg"
                style="cursor: pointer;">
                <path
                    d="M9.52447 1.46353C9.67415 1.00287 10.3259 1.00287 10.4755 1.46353L12.1329 6.56434C12.1998 6.77035 12.3918 6.90983 12.6084 6.90983H17.9717C18.4561 6.90983 18.6575 7.52964 18.2656 7.81434L13.9266 10.9668C13.7514 11.0941 13.678 11.3198 13.745 11.5258L15.4023 16.6266C15.552 17.0873 15.0248 17.4704 14.6329 17.1857L10.2939 14.0332C10.1186 13.9059 9.88135 13.9059 9.70611 14.0332L5.3671 17.1857C4.97524 17.4704 4.448 17.0873 4.59768 16.6266L6.25503 11.5258C6.32197 11.3198 6.24864 11.0941 6.07339 10.9668L1.73438 7.81434C1.34253 7.52964 1.54392 6.90983 2.02828 6.90983H7.39159C7.6082 6.90983 7.80018 6.77035 7.86712 6.56434L9.52447 1.46353Z"
                    stroke="#A2A2A2" stroke-width="1.5" />
            </svg>
        </td>
        <td style="font-size: 11px;padding: 5px 10px 5px 16px">
            {{ $email->sender->name ?? '-' }}</td>
        <td style="padding: 5px 10px 5px 16px">
            <svg width="18" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10.3573 5.58626C10.2523 6.20027 10.2791 6.82994 10.4358 7.43257C10.5925 8.03519 10.8755 8.59667 11.2655 9.07892C11.6556 9.56118 12.1436 9.95292 12.6964 10.2276C13.2493 10.5022 13.854 10.6534 14.4697 10.6708L18.1129 10.7745C19.2391 10.7867 20.3249 10.3509 21.1366 9.56104C21.9483 8.77115 22.4209 7.69031 22.4525 6.55133C22.4842 5.41235 22.0724 4.30635 21.3059 3.47155C20.5393 2.63675 19.4794 2.13994 18.3543 2.08812L16.2718 2.02272M13.9663 6.91853C14.0713 6.30452 14.0446 5.67485 13.8879 5.07222C13.7312 4.4696 13.4482 3.90812 13.0581 3.42587C12.6681 2.94361 12.1801 2.55187 11.6272 2.2772C11.0744 2.00254 10.4696 1.85138 9.85395 1.83398L6.21078 1.73032C5.08462 1.71809 3.99875 2.15385 3.18707 2.94375C2.37538 3.73364 1.90282 4.81448 1.87116 5.95346C1.8395 7.09244 2.25128 8.19844 3.0178 9.03324C3.78433 9.86804 4.84427 10.3648 5.96934 10.4167L8.04594 10.4758"
                    stroke="#1E1E1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </td>
        <td style="font-size: 11px;padding: 5px 10px 5px 16px">
            {{ Str::limit($email->subject ?? '-', 20) }}</td>
        <td style="font-size: 11px;padding: 5px 10px 5px 16px">
            {{ \Carbon\Carbon::parse($email->date)->format('d, M Y') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center" style="padding: 15px;">
            No Emails
        </td>
    </tr>
@endforelse


@push('scripts')
<script>
document.body.addEventListener('click', function (e) {
    if (e.target.closest('.star-toggle')) {
        const star = e.target.closest('.star-toggle');
        const emailId = star.dataset.id;

        fetch(`/emails/star-toggle/${emailId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            star.setAttribute('fill', data.is_starred ? 'yellow' : 'none');
        })
        .catch(error => {
            console.error('Error toggling star:', error);
        });
    }
});

</script>
@endpush
