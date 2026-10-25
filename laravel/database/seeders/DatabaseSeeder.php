<?php

namespace Database\Seeders;

use App\Models\Episode;
use App\Models\Genre;
use App\Models\Review;
use App\Models\Role;
use App\Models\Series;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with Top American Series (IMDb) and Anime (Crunchyroll).
     */
    public function run(): void
    {
        // 1. Roles
        $adminRole = Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name_en' => 'Administrator', 'name_ar' => 'مدير النظام']
        );

        $managerRole = Role::updateOrCreate(
            ['slug' => 'manager'],
            ['name_en' => 'Content Manager', 'name_ar' => 'مدير المحتوى']
        );

        $userRole = Role::updateOrCreate(
            ['slug' => 'user'],
            ['name_en' => 'Standard User', 'name_ar' => 'مستخدم قياسي']
        );

        // 2. Default Accounts (Media TV brand + backwards-compatible)
        $admin = User::updateOrCreate(
            ['email' => 'admin@mediatv.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@anitrack.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole->id,
            ]
        );

        $manager = User::updateOrCreate(
            ['email' => 'manager@mediatv.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password123'),
                'role_id' => $managerRole->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@anitrack.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password123'),
                'role_id' => $managerRole->id,
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@mediatv.com'],
            [
                'name' => 'Tariq Al-Mansoor',
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@anitrack.com'],
            [
                'name' => 'Tariq Al-Mansoor',
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ]
        );

        // 3. Genres (Anime + American TV categories)
        $genresData = [
            ['slug' => 'crime', 'name_en' => 'Crime', 'name_ar' => 'جريمة'],
            ['slug' => 'drama', 'name_en' => 'Drama', 'name_ar' => 'دراما'],
            ['slug' => 'thriller', 'name_en' => 'Thriller', 'name_ar' => 'إثارة وتشويق'],
            ['slug' => 'action', 'name_en' => 'Action', 'name_ar' => 'أكشن'],
            ['slug' => 'adventure', 'name_en' => 'Adventure', 'name_ar' => 'مغامرات'],
            ['slug' => 'sci-fi', 'name_en' => 'Sci-Fi', 'name_ar' => 'خيال علمي'],
            ['slug' => 'fantasy', 'name_en' => 'Fantasy', 'name_ar' => 'فانتازيا'],
            ['slug' => 'mystery', 'name_en' => 'Mystery', 'name_ar' => 'غموض'],
            ['slug' => 'shounen', 'name_en' => 'Shounen', 'name_ar' => 'شونين'],
            ['slug' => 'supernatural', 'name_en' => 'Supernatural', 'name_ar' => 'خوارق الطبيعة'],
            ['slug' => 'history', 'name_en' => 'History', 'name_ar' => 'تاريخي'],
            ['slug' => 'horror', 'name_en' => 'Horror', 'name_ar' => 'رعب'],
        ];

        $genres = [];
        foreach ($genresData as $item) {
            $genres[$item['slug']] = Genre::updateOrCreate(['slug' => $item['slug']], $item);
        }

        // 4. Combined Catalog: Top American TV Series (IMDb) + Top Anime (Crunchyroll) + Movies
        $seriesList = [
            // --- TOP AMERICAN TV SERIES (IMDb) ---
            [
                'slug' => 'breaking-bad',
                'title_en' => 'Breaking Bad',
                'title_ar' => 'بريكينغ باد (اختلال ضال)',
                'synopsis_en' => 'A chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine with a former student in order to secure his family financial future.',
                'synopsis_ar' => 'معلم كيمياء في المدرسة الثانوية يُشخَّص بسرطان رئة غير قابل للشفاء، فيتحول إلى تصنيع وتجارة الميثامفيتامين بمساعدة طالب سابق لتأمين مستقبل عائلته المالي.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 62,
                'release_year' => 2008,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg',
                'genres' => ['crime', 'drama', 'thriller'],
            ],
            [
                'slug' => 'game-of-thrones',
                'title_en' => 'Game of Thrones',
                'title_ar' => 'صراع العروش',
                'synopsis_en' => 'Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for millennia.',
                'synopsis_ar' => 'تسع عائلات نبيلة تتنافس وتتحارب من أجل السيطرة على العرش الحديدي في قارة ويستروس، بينما يستيقظ عدو قديم ومرعب في الشمال الجليدي بعد آلاف السنين.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 73,
                'release_year' => 2011,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/1XS1oqL89opfnbLl8WnZY1O1uJx.jpg',
                'genres' => ['action', 'adventure', 'drama', 'fantasy'],
            ],
            [
                'slug' => 'stranger-things',
                'title_en' => 'Stranger Things',
                'title_ar' => 'أشياء غريبة (سترينجر ثينقز)',
                'synopsis_en' => 'When a young boy vanishes, a small town uncovers a mystery involving secret experiments, terrifying supernatural forces and one strange little girl with telekinetic powers.',
                'synopsis_ar' => 'عندما يختفي صبي صغير فجأة، تكشف بلدة هوكينز الصغيرة لغزاً يتضمن تجارب حكومية سرية وقوى خارقة للطبيعة وفتاة صغيرة غامضة تمتلك قدرات خارقة.',
                'type' => 'TV',
                'status' => 'Airing',
                'total_episodes' => 34,
                'release_year' => 2016,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/49WJfeN0moxb9IPfGn8AIqMGskD.jpg',
                'genres' => ['drama', 'fantasy', 'horror', 'sci-fi'],
            ],
            [
                'slug' => 'the-last-of-us',
                'title_en' => 'The Last of Us',
                'title_ar' => 'ذا لاست أوف أس (آخرنا)',
                'synopsis_en' => 'After a global pandemic destroys civilization, a hardened survivor takes charge of a 14-year-old girl who may be humanity last hope.',
                'synopsis_ar' => 'بعد أن يدمر وباء فطري عالمي الحضارة البشرية، يتولى أحد الناجين القساة مهمة تهريب فتاة تبلغ من العمر 14 عاماً عبر أمريكا المدمرة لأنها قد تكون الأمل الأخير للبشرية.',
                'type' => 'TV',
                'status' => 'Airing',
                'total_episodes' => 9,
                'release_year' => 2023,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/uKVqqizhuxHaCu4aqHR47g290qI.jpg',
                'genres' => ['action', 'adventure', 'drama', 'sci-fi'],
            ],
            [
                'slug' => 'chernobyl',
                'title_en' => 'Chernobyl',
                'title_ar' => 'تشرنوبل',
                'synopsis_en' => 'In April 1986, an explosion at the Chernobyl nuclear power plant in the USSR becomes one of the world worst man-made catastrophes.',
                'synopsis_ar' => 'في أبريل 1986، أدى انفجار في محطة تشيرنوبيل للطاقة النووية في الاتحاد السوفيتي إلى واحدة من أسوأ الكوارث البشرية في تاريخ العالم.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 5,
                'release_year' => 2019,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/hlLXt2tOPT6RRnjiUmoxyG1LTFi.jpg',
                'genres' => ['drama', 'history', 'thriller'],
            ],
            [
                'slug' => 'better-call-saul',
                'title_en' => 'Better Call Saul',
                'title_ar' => 'من الأفضل الاتصال بسول',
                'synopsis_en' => 'The trials and tribulations of criminal lawyer Jimmy McGill in the years leading up to his fateful run-in with Walter White and Jesse Pinkman.',
                'synopsis_ar' => 'يروي المسلسل قصة المحامي الطموح جيمي ماكغيل وتحوله التدريجي والمثير للجدل إلى المحامي الجنائي المتلاعب سول غودمان.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 63,
                'release_year' => 2015,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/fC2HDm5t0kHjUmYIMBYVUVYrpyv.jpg',
                'genres' => ['crime', 'drama'],
            ],

            // --- TOP CRUNCHYROLL ANIME ---
            [
                'slug' => 'attack-on-titan',
                'title_en' => 'Attack on Titan',
                'title_ar' => 'هجوم العمالقة',
                'synopsis_en' => 'After his hometown is destroyed and his mother is killed, young Eren Jaeger vows to cleanse the earth of the giant humanoid Titans.',
                'synopsis_ar' => 'بعد تدمير مسقط رأسه ومقتل والدته، يقسم الشاب إرين ييغر على تطهير الأرض من العمالقة الشبيهين بالبشر الذين قادوا البشرية إلى حافة الانقراض.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 89,
                'release_year' => 2013,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/hTP1DtLGFamjfu8WqjnuQdP1n4i.jpg',
                'genres' => ['action', 'drama', 'fantasy', 'mystery', 'shounen'],
            ],
            [
                'slug' => 'frieren-beyond-journeys-end',
                'title_en' => "Frieren: Beyond Journey's End",
                'title_ar' => 'فريرين: ما بعد نهاية الرحلة',
                'synopsis_en' => 'An elf mage and her fellow adventurers have defeated the Demon King, bringing peace to the land. But Frieren witnesses her mortal companions pass away and embarks on a journey to understand humanity.',
                'synopsis_ar' => 'ساحرة من جنس الإلف ورفاقها الأبطال هزموا ملك الشياطين وأحلوا السلام في الأرض. ولكن مع مرور العقود، تشهد فريرين رحيل رفاقها الفانين وتبدأ رحلة جديدة لفهم المشاعر الإنسانية.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 28,
                'release_year' => 2023,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/dqZENchTd7lp5zht7BdlqM7RBhD.jpg',
                'genres' => ['adventure', 'drama', 'fantasy', 'shounen'],
            ],
            [
                'slug' => 'jujutsu-kaisen',
                'title_en' => 'Jujutsu Kaisen',
                'title_ar' => 'جوجوتسو كايسن',
                'synopsis_en' => 'A boy swallows a cursed talisman - the finger of a demon - and enters a shaman school to locate the demons remaining fingers.',
                'synopsis_ar' => 'يبتلع فتى تميمة ملعونة - إصبع شيطان قوي - ليصبح ملعوناً بدوره. يلتحق بمدرسة طاردي الأرواح الشريرة ليتمكن من جمع بقية أجزاء الشيطان وتطهير اللعنة.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 47,
                'release_year' => 2020,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/fHpKWK8fO969iJqM0b2H5a7Cg9e.jpg',
                'genres' => ['action', 'supernatural', 'shounen'],
            ],
            [
                'slug' => 'demon-slayer',
                'title_en' => 'Demon Slayer: Kimetsu no Yaiba',
                'title_ar' => 'قاتل الشياطين',
                'synopsis_en' => 'A youth begins a quest to fight demons and save his sister after finding his family slaughtered and his sister turned into a demon.',
                'synopsis_ar' => 'يبدأ فتى رحلة شاقة لمحاربة الشياطين وإنقاذ أخته بعد مقتل عائلته وتحول أخته الوحيدة الناجية إلى شيطانة.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 55,
                'release_year' => 2019,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg',
                'genres' => ['action', 'fantasy', 'shounen'],
            ],
            [
                'slug' => 'death-note',
                'title_en' => 'Death Note',
                'title_ar' => 'مذكرة الموت',
                'synopsis_en' => 'An intelligent high school student goes on a secret crusade to eliminate criminals from the world after discovering a notebook capable of killing anyone whose name is written into it.',
                'synopsis_ar' => 'يعثر طالب ثانوية عبقري على مفكرة خارقة تقتل أي شخص يُكتب اسمه فيها، فيقرر استخدامها لتخليص العالم من المجرمين وخلق عالم مثالي، مما يضعه في صراع ذهني مع المحقق الغامض L.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 37,
                'release_year' => 2006,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/tCZFDi1Nuq454F6y98Fwh3g9vnh.jpg',
                'genres' => ['mystery', 'thriller', 'supernatural', 'shounen'],
            ],
            [
                'slug' => 'one-piece',
                'title_en' => 'One Piece',
                'title_ar' => 'ون بيس',
                'synopsis_en' => 'Monkey D. Luffy sails with his crew of Straw Hat Pirates through the Grand Line to find the legendary treasure One Piece and become the Pirate King.',
                'synopsis_ar' => 'يبحر الفتى المطاطي مونكي دي لوفي مع طاقمه قراصنة قبعة القش عبر الجراند لاين بحثاً عن الكنز الأسطوري ون بيس ليصبح ملك القراصنة القادم.',
                'type' => 'TV',
                'status' => 'Airing',
                'total_episodes' => 1100,
                'release_year' => 1999,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/cMD9Ygz11yjqkzbEiGUeh4a9Y62.jpg',
                'genres' => ['action', 'adventure', 'fantasy', 'shounen'],
            ],
            [
                'slug' => 'steins-gate',
                'title_en' => 'Steins;Gate',
                'title_ar' => 'شتاينز؛غيت',
                'synopsis_en' => 'A self-proclaimed mad scientist inadvertently discovers time travel via a microwave and finds himself caught in a conspiracy of world proportions.',
                'synopsis_ar' => 'عالم مجنون يعلن عن نفسه يكتشف بالصدفة السفر عبر الزمن باستخدام ميكروويف ويجد نفسه متورطاً في مؤامرة عالمية مرعبة.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 24,
                'release_year' => 2011,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/gDvxT2z6TNxervG97WfpePRZ3aR.jpg',
                'genres' => ['sci-fi', 'thriller', 'shounen'],
            ],
            [
                'slug' => 'fullmetal-alchemist-brotherhood',
                'title_en' => 'Fullmetal Alchemist: Brotherhood',
                'title_ar' => 'الخيميائي الفولاذي: فل ميتال ألكمست',
                'synopsis_en' => 'Two brothers search for a Philosopher Stone after an attempt to revive their deceased mother goes awry and leaves them in damaged physical forms.',
                'synopsis_ar' => 'يبحث أخوان عن حجر الفلاسفة الأسطوري بعد فشل محاولة محرمة لإعادة والدتهما المتوفاة مما كلفهما أجسادهما.',
                'type' => 'TV',
                'status' => 'Finished',
                'total_episodes' => 64,
                'release_year' => 2009,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/suKjebkLyhScO5054blqSHOX3Gk.jpg',
                'genres' => ['action', 'adventure', 'fantasy', 'shounen'],
            ],

            // --- FEATURED MOVIES (أفلام مختارة) ---
            [
                'slug' => 'inception',
                'title_en' => 'Inception',
                'title_ar' => 'استهلال (إنسبشن)',
                'synopsis_en' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'synopsis_ar' => 'لص محترف يسرق أسرار الشركات عبر تقنية التسلل إلى الأحلام، يُعرض عليه عمل شبه مستحيل لزرع فكرة في عقل وريث إمبراطورية تجارية مقابل استعادة حياته.',
                'type' => 'Movie',
                'status' => 'Finished',
                'total_episodes' => 1,
                'release_year' => 2010,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg',
                'genres' => ['action', 'sci-fi', 'thriller'],
            ],
            [
                'slug' => 'oppenheimer',
                'title_en' => 'Oppenheimer',
                'title_ar' => 'أوبنهايمر',
                'synopsis_en' => 'The story of American scientist J. Robert Oppenheimer and his role in the development of the atomic bomb during World War II.',
                'synopsis_ar' => 'سيرة العالم الأمريكي روبرت أوبنهايمر ودوره المحوري في قيادة مشروع مانهاتن وتطوير القنبلة الذرية التي غيرت مجرى تاريخ البشرية للأبد.',
                'type' => 'Movie',
                'status' => 'Finished',
                'total_episodes' => 1,
                'release_year' => 2023,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/8Gxv8gSFCU0XGDykEGv7zR1n2ua.jpg',
                'genres' => ['drama', 'history', 'thriller'],
            ],
            [
                'slug' => 'interstellar',
                'title_en' => 'Interstellar',
                'title_ar' => 'بين النجوم (إنترستيلار)',
                'synopsis_en' => 'When Earth becomes uninhabitable in the future, a farmer and ex-NASA pilot, Joseph Cooper, is tasked to pilot a spacecraft, along with a team of researchers, to find a new planet for humans.',
                'synopsis_ar' => 'عندما تصبح الأرض غير صالحة للعيش، يقود طيار ناسا السابق كوبر فريقاً من المستكشفين عبر ثقب دودي فضائي للبحث عن كوكب بديل لإنقاذ البشرية.',
                'type' => 'Movie',
                'status' => 'Finished',
                'total_episodes' => 1,
                'release_year' => 2014,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
                'genres' => ['adventure', 'drama', 'sci-fi'],
            ],
            [
                'slug' => 'the-dark-knight',
                'title_en' => 'The Dark Knight',
                'title_ar' => 'فارس الظلام',
                'synopsis_en' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'synopsis_ar' => 'عندما يظهر الجوكر ليعيث فساداً وفوضى عارمة في مدينة غوثام، يخوض باتمان أعظم اختبار نفسي وبدني لأخلاقياته وقدرته على محاربة الجريمة.',
                'type' => 'Movie',
                'status' => 'Finished',
                'total_episodes' => 1,
                'release_year' => 2008,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
                'genres' => ['action', 'crime', 'drama', 'thriller'],
            ],
            [
                'slug' => 'spirited-away',
                'title_en' => 'Spirited Away',
                'title_ar' => 'المخطوفة (سبيريتد أواي)',
                'synopsis_en' => 'During her family move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches and spirits, a world where humans are changed into beasts.',
                'synopsis_ar' => 'أثناء انتقال عائلتها، تعثر الفتاة الصغيرة شيهيرو على عالم سحري غامض تحكمه الأرواح والساحرات، حيث يتحول والداها إلى خنازير ويتحتم عليها العمل لإنقاذهما.',
                'type' => 'Movie',
                'status' => 'Finished',
                'total_episodes' => 1,
                'release_year' => 2001,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/39wmItIWsg5sZMyRUHLkWBcuVCM.jpg',
                'genres' => ['adventure', 'fantasy', 'shounen'],
            ],
            [
                'slug' => 'your-name',
                'title_en' => 'Your Name.',
                'title_ar' => 'اسمك (كيمي نو نا وا)',
                'synopsis_en' => 'Two teenagers share a profound, magical connection upon discovering they are swapping bodies. Things manage to become even more complicated when the boy and girl decide to meet in person.',
                'synopsis_ar' => 'يكتشف مراهقان أنهما يتبادلان أجسادهما في أحلامهما بشكل غامض رغم بعد المسافة بينهما، فتبدأ رحلة بحث مؤثرة للقاء أحدهما الآخر وتغيير مصير مأساوي.',
                'type' => 'Movie',
                'status' => 'Finished',
                'total_episodes' => 1,
                'release_year' => 2016,
                'poster_image' => 'https://image.tmdb.org/t/p/w500/q719jXXEzOoYaps6qFsC8llRaQ.jpg',
                'genres' => ['drama', 'fantasy', 'shounen', 'supernatural'],
            ],
        ];

        foreach ($seriesList as $data) {
            $genresToSync = $data['genres'];
            unset($data['genres']);

            $series = Series::updateOrCreate(['slug' => $data['slug']], $data);

            $genreIds = [];
            foreach ($genresToSync as $gSlug) {
                if (isset($genres[$gSlug])) {
                    $genreIds[] = $genres[$gSlug]->id;
                }
            }
            $series->genres()->sync($genreIds);

            // Populate sample episode guide (first 5 episodes)
            for ($ep = 1; $ep <= min(5, $series->total_episodes); $ep++) {
                Episode::updateOrCreate(
                    [
                        'series_id' => $series->id,
                        'episode_number' => $ep,
                    ],
                    [
                        'title_en' => "Episode {$ep}",
                        'title_ar' => "الحلقة {$ep}",
                        'air_date' => now()->subMonths(12 - $ep)->toDateString(),
                    ]
                );
            }
        }

        // 5. Watchlist & Reviews for Demo User
        $bb = Series::where('slug', 'breaking-bad')->first();
        if ($bb) {
            Watchlist::updateOrCreate(
                ['user_id' => $user->id, 'series_id' => $bb->id],
                ['status' => 'Completed', 'progress_episodes' => 62]
            );

            Review::updateOrCreate(
                ['user_id' => $user->id, 'series_id' => $bb->id],
                [
                    'rating' => 10,
                    'comment' => 'Peak television from start to finish. Bryan Cranston delivers a masterclass. أفضل مسلسل درامي في تاريخ التلفزيون بلا منازع.',
                    'is_approved' => true,
                ]
            );
        }

        $aot = Series::where('slug', 'attack-on-titan')->first();
        if ($aot) {
            Watchlist::updateOrCreate(
                ['user_id' => $user->id, 'series_id' => $aot->id],
                ['status' => 'Watching', 'progress_episodes' => 45]
            );

            Review::updateOrCreate(
                ['user_id' => $user->id, 'series_id' => $aot->id],
                [
                    'rating' => 10,
                    'comment' => 'Unbelievable narrative complexity and legendary music score. عمل أسطوري لا يُنسى.',
                    'is_approved' => true,
                ]
            );
        }

        $stranger = Series::where('slug', 'stranger-things')->first();
        if ($stranger) {
            Watchlist::updateOrCreate(
                ['user_id' => $user->id, 'series_id' => $stranger->id],
                ['status' => 'Watching', 'progress_episodes' => 20]
            );
        }

        $frieren = Series::where('slug', 'frieren-beyond-journeys-end')->first();
        if ($frieren) {
            Watchlist::updateOrCreate(
                ['user_id' => $user->id, 'series_id' => $frieren->id],
                ['status' => 'Completed', 'progress_episodes' => 28]
            );
        }
    }
}
