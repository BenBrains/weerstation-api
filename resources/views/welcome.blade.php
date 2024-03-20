<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Weerstation API</title>
    <meta name="description"
          content="The one and only API for the weerstation project. Built with Laravel and open-source.">

    <!--
        This is terrible and not recommended for production, but it's a quick way to get started for this example.
        https://tailwindcss.com/docs/installation/play-cdn
    -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="">

<div class="bg-slate-900 h-screen max-h-screen">
    <div class="bg-gradient-to-b from-violet-600/[.15] via-transparent">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-40 space-y-8">
            <!-- Announcement Chip -->
            <div class="flex justify-center">
                <a
                    class="group inline-block bg-white/[.05] hover:bg-white/[.1] border border-white/[.05] p-1 ps-4 rounded-full shadow-md"
                    href="https://github.com/BenBrains/weerstation-api"
                    target="_blank"
                >
                    <p class="inline-block text-sm text-white me-2">The one and only GitHub repo</p>
                    <span
                        class="group-hover:bg-white/[.1] py-1.5 px-2.5 inline-flex justify-center items-center gap-x-2 rounded-full bg-white/[.075] font-semibold text-white text-sm"
                    >
						<svg
                            class="flex-shrink-0 size-4"
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            fill="none"
                        >
							<path
                                d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
						</svg>
					</span>
                </a>
            </div>
            <!-- End Announcement Chip -->

            <!-- Title -->
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="block text-4xl font-medium text-gray-200 sm:text-5xl md:text-6xl lg:text-7xl">
                    Weerstation API
                </h1>
            </div>
            <!-- End Title -->

            <div class="max-w-3xl mx-auto text-center">
                <p class="text-lg text-gray-400">
                    The one and only API for the weerstation project. Built with Laravel and open-source.
                </p>
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <a
                    class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-center text-white border border-transparent rounded-full shadow-lg gap-x-3 bg-gradient-to-tl from-blue-600 to-violet-600 shadow-transparent hover:shadow-blue-700/50 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800"
                    href="/docs/api"
                >
                    Get started
                    <svg
                        class="flex-shrink-0 size-4"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg
                    >
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>



