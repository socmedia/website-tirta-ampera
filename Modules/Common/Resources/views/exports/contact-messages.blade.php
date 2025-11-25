<table>
    <thead>
        <tr>
            <th colspan="8" height="30" style="font-size: 18px; font-weight: bold; text-align: left;">
                {{ __('Contact Messages Export') }}
            </th>
        </tr>
        <tr>
            <th colspan="8" height="20" style="font-size: 13px; text-align: left;">
                {{ __('Export Date:') }} {{ now()->format('D, d M Y. H:i:s') }}
            </th>
        </tr>
        <tr></tr> <!-- Empty row for spacing -->
        <tr>
            <th height="25" width="5">{{ __('No.') }}</th>
            <th height="25" width="30">{{ __('Name') }}</th>
            <th height="25" width="30">{{ __('Email') }}</th>
            <th height="25" width="35">{{ __('WhatsApp') }}</th>
            <th height="25" width="40">{{ __('Subject') }}</th>
            <th height="25" width="60">{{ __('Message') }}</th>
            <th height="25" width="20">{{ __('Status') }}</th>
            <th height="25" width="25">{{ __('Created At') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $message)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{ $message->name ?? __('(No Name)') }}
                </td>
                <td>
                    {{ $message->email ?? __('(No Email)') }}
                </td>
                <td>
                    {{ $message->whatsapp_formatted ?? __('(No WhatsApp)') }}
                </td>
                <td>
                    {{ $message->subject ?? __('(No Subject)') }}
                </td>
                <td>
                    @if (!empty($message->message))
                        {{ $message->message }}
                    @else
                        <span style="color: #888;">{{ __('(No Message)') }}</span>
                    @endif
                </td>
                <td style="text-align: center">
                    @php
                        $seen_at = $message->seen_at ?? null;
                        $status = $seen_at ? __('Seen') : __('Unseen');
                        $seenBy = $message->seenBy && isset($message->viewer->name) ? $message->viewer->name : '-';
                    @endphp
                    {{ $status }}
                    @if ($seen_at)
                        <br>
                        <span style="font-size: 11px; color: #888;">
                            {{ __('by') }} {{ $seenBy }}
                        </span>
                    @endif
                </td>
                <td>
                    {{ $message->formatted_created_at ?? '' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #888; font-style: italic;">
                    {{ __('No contact messages found.') }}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
