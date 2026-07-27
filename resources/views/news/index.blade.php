@extends('layouts.app')

@section('title', 'News Intelligence')

@section('content')

<div class="page-header">

    <h1>📰 News Intelligence</h1>

    <p>
        Monitoring berita global yang dapat memengaruhi
        kondisi dan risiko Global Supply Chain.
    </p>

</div>


<div class="cards">

    <div class="card">

        <div class="card-title">
            📰 Total News
        </div>

        <div class="card-number">
            {{ $news->count() }}
        </div>

        <p>
            Total berita yang dipantau
        </p>

    </div>


    <div class="card">

        <div class="card-title">
            🔴 High Impact
        </div>

        <div class="card-number">

            {{
                $news
                    ->where('impact_level', 'High')
                    ->count()
            }}

        </div>

        <p>
            Berita berdampak tinggi
        </p>

    </div>


    <div class="card">

        <div class="card-title">
            🟡 Medium Impact
        </div>

        <div class="card-number">

            {{
                $news
                    ->where('impact_level', 'Medium')
                    ->count()
            }}

        </div>

        <p>
            Berita berdampak sedang
        </p>

    </div>


    <div class="card">

        <div class="card-title">
            🟢 Low Impact
        </div>

        <div class="card-number">

            {{
                $news
                    ->where('impact_level', 'Low')
                    ->count()
            }}

        </div>

        <p>
            Berita berdampak rendah
        </p>

    </div>

</div>


<div class="table-container">

    <h2>
        📰 Global Supply Chain News
    </h2>

    <div style="overflow-x: auto;">

        <table>

            <thead>

                <tr>

                    <th>#</th>

                    <th>Title</th>

                    <th>Source</th>

                    <th>Category</th>

                    <th>Country</th>

                    <th>Impact</th>

                    <th>Published</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                @forelse($news as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        <td>

                            <strong>
                                {{ $item->title }}
                            </strong>

                            @if($item->summary)

                                <p style="
                                    margin: 5px 0 0;
                                    color: #64748b;
                                    font-size: 13px;
                                ">

                                    {{ $item->summary }}

                                </p>

                            @endif

                        </td>


                        <td>

                            {{ $item->source ?? '-' }}

                        </td>


                        <td>

                            {{ $item->category ?? '-' }}

                        </td>


                        <td>

                            {{ $item->country ?? '-' }}

                        </td>


                        <td>

                            @if(
                                $item->impact_level === 'High'
                            )

                                <span style="
                                    color: #dc2626;
                                    font-weight: 700;
                                ">

                                    🔴 High

                                </span>

                            @elseif(
                                $item->impact_level === 'Medium'
                            )

                                <span style="
                                    color: #ca8a04;
                                    font-weight: 700;
                                ">

                                    🟡 Medium

                                </span>

                            @else

                                <span style="
                                    color: #16a34a;
                                    font-weight: 700;
                                ">

                                    🟢 Low

                                </span>

                            @endif

                        </td>


                        <td>

                            {{
                                $item->published_at
                                    ? $item
                                        ->published_at
                                        ->format(
                                            'd M Y H:i'
                                        )
                                    : '-'
                            }}

                        </td>


                        <td>

                            @if($item->url)

                                <a
                                    href="{{ $item->url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    style="
                                        display: inline-block;
                                        padding: 8px 12px;
                                        background: #2563eb;
                                        color: white;
                                        border-radius: 6px;
                                        text-decoration: none;
                                    "
                                >

                                    🔗 Read

                                </a>

                            @else

                                -

                            @endif

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="8"
                            style="
                                text-align: center;
                                padding: 30px;
                            "
                        >

                            📰 Belum ada berita
                            yang tersedia.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection