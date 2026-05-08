@php
    $assignments = $getRecord()->assignments;
@endphp

<div class="overflow-x-auto">
    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="border-b font-semibold text-left">
                <th class="py-2 pr-4">Volunteer</th>
                <th class="py-2 pr-4">Start Date</th>
                <th class="py-2 pr-4">End Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($assignments as $assignment)
                <tr class="border-b">
                    <td class="py-2 pr-4">
                        {{ $assignment->volunteer->user->name }}
                    </td>

                    <td class="py-2 pr-4">
                        {{ \Carbon\Carbon::parse($assignment->start_date)->format('d M Y') }}
                    </td>

                    <td class="py-2 pr-4">
                        {{ \Carbon\Carbon::parse($assignment->end_date)->format('d M Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>