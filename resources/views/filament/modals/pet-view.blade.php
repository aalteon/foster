<div style="display:flex; flex-direction:column; gap:20px;">

    <!-- HEADER -->
    <div style="display:flex; gap:20px; align-items:center;">
        <img 
            src="{{ asset('storage/' . $record->image) }}" 
            style="width:110px; height:110px; object-fit:cover; border-radius:12px; border:1px solid #ddd;"
        >

        <div>
            <h2 style="font-size:18px; font-weight:600; margin:0;">
                {{ $record->name }}
            </h2>

            <p style="margin:4px 0; color:#666;">
                {{ $record->species }} • {{ $record->breed ?? '-' }}
            </p>

            <span style="
                display:inline-block;
                padding:4px 10px;
                border-radius:999px;
                font-size:12px;
                background: {{ $record->gender === 'male' ? '#e0edff' : '#ffe4ec' }};
                color: {{ $record->gender === 'male' ? '#1d4ed8' : '#be185d' }};
            ">
                {{ ucfirst($record->gender ?? 'unknown') }}
            </span>
        </div>
    </div>

    <!-- DETAILS -->
    <div style="
        background:#f9fafb;
        border-radius:12px;
        padding:16px;
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:12px;
        font-size:14px;
    ">
        <div>
            <div style="color:#666;">Weight</div>
            <div style="font-weight:500;">{{ $record->weight ?? '-' }} kg</div>
        </div>

        <div>
            <div style="color:#666;">DOB</div>
            <div style="font-weight:500;">{{ $record->dob ?? '-' }}</div>
        </div>

        <div>
            <div style="color:#666;">Color</div>
            <div style="font-weight:500;">{{ $record->color ?? '-' }}</div>
        </div>

        <div>
            <div style="color:#666;">Species</div>
            <div style="font-weight:500;">{{ $record->species ?? '-' }}</div>
        </div>

        <div>
            <div style="color:#666;">Breed</div>
            <div style="font-weight:500;">{{ $record->breed ?? '-' }}</div>
        </div>
    </div>

    <!-- DESCRIPTION -->
    <div>
        <div style="font-size:14px; color:#666; margin-bottom:6px;">
            Description
        </div>

        <div style="
            background:#f9fafb;
            border-radius:12px;
            padding:14px;
            font-size:14px;
            line-height:1.6;
            color:#333;
        ">
            {{ $record->description ?? '-' }}
        </div>
    </div>

</div>