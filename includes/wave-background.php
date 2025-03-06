<svg id="waves-bg" width="100%" height="700px" xmlns="http://www.w3.org/2000/svg" class="absolute top-20">
    <defs>
        <filter id="inset-shadow" x="-50%" y="-50%" width="200%" height="200%">
            <feComponentTransfer in="SourceAlpha">
                <feFuncA type="table" tableValues="1 0" />
            </feComponentTransfer>
            <feGaussianBlur stdDeviation="5" />
            <feOffset dx="0" dy="3" result="offsetblur" />
            <feFlood flood-color="black" result="color" />
            <feComposite in2="offsetblur" operator="in" />
            <feComposite in2="SourceAlpha" operator="in" />
            <feMerge>
                <feMergeNode in="SourceGraphic" />
                <feMergeNode />
            </feMerge>
        </filter>
    </defs>
    <path id="waves-path" d="M 0 60 q 100 30 150 -20 q 75 -70 300 0 l 180 600 l -800 0" stroke="none" stroke-width="0" fill="white" filter="url(#inset-shadow)"/>
</svg>