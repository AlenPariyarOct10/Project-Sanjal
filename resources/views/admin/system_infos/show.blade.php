@extends('layouts.admin')

@section('css')
    <style>
        /* Glow Border Hover */
        .hover-glow:hover {
            box-shadow: 0 0 0 0.5px black inset;
            cursor: pointer;
        }

        .small-btn {
            transition: all 0.2s linear;
            cursor: pointer;
        }

        .small-btn:hover{
            background: black;
            color: white;
            border-color: black;
            box-shadow: 0 0 6px rgba(0,0,0,0.5);
            cursor: pointer;
        }

        .go-back-btn {
            transition: all 0.2s linear;
            cursor: pointer;
        }
        .go-back-btn:hover {
            background: black;
            color: white;
            box-shadow: 0 0 6px rgba(0,0,0,0.6);
            text-decoration: none;
        }
    </style>
@endsection

@section('content')

<!-- MAIN CONTENT -->
<main class="">


    <div class="max-w-6xl mx-auto px-4">
        <a href="{{ route($base_route . 'index') }}"
           class="inline-block border border-black px-6 py-1 mt-2 mb-4 go-back-btn text-sm">
            ← Go Back
        </a>
        <!-- UNIVERSITY DETAILS -->
        <section class="border border-black p-8 hover-glow">
            <h1 class="text-3xl font-bold mb-4">{{ $row->key }}</h1>

            <p class="text-sm leading-relaxed">
                System Info
            </p>

            <div class="overflow-x-auto mt-4">
                <table class="w-full border-collapse border border-black text-sm">
                    <thead>
                    <tr class="bg-gray-100 border-b border-black">
                        <th class="border border-black px-4 py-2 text-left">Key</th>
                        <th class="border border-black px-4 py-2 text-left">Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($row->getFillable() as $value)
                        <tr class="hover-glow">
                            <td class="border border-black px-4 py-2">{{ $value }}</td>
                            <td class="border border-black px-4 py-2">{{ $row->{$value} }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>


    </div>
</main>
@endsection
