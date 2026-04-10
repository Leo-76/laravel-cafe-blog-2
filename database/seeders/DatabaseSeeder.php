<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::factory()->create([
            'name'     => 'Admin Cafeotheque',
            'email'    => 'admin@cafeblog.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'bio'      => 'Passionné de café, barista et formateur certifié SCA.',
        ]);

        // Categories
        $categories = collect([
            ['name' => 'Origines', 'slug' => 'origines', 'description' => 'L\'histoire et la géographie du café à travers le monde.'],
            ['name' => 'Méthodes de préparation', 'slug' => 'preparation', 'description' => 'Toutes les techniques d\'extraction : espresso, filtre, immersion.'],
            ['name' => 'Dégustation', 'slug' => 'degustation', 'description' => 'Notes aromatiques, cupping et développement du palais.'],
            ['name' => 'Matériel', 'slug' => 'materiel', 'description' => 'Machines, moulins et accessoires incontournables.'],
            ['name' => 'Torréfaction', 'slug' => 'torrefaction', 'description' => 'Du grain vert à la torréfaction artisanale.'],
            ['name' => 'Culture café', 'slug' => 'culture', 'description' => 'Le café et son rôle social, artistique et économique.'],
        ])->map(fn ($cat) => Category::create($cat));

        // Tags
        $tagNames = [
            'espresso', 'v60', 'chemex', 'aeropress', 'cold-brew',
            'arabica', 'robusta', 'éthiopie', 'colombie', 'brésil', 'kenya',
            'latte-art', 'single-origin', 'specialty', 'torréfaction-claire',
            'torréfaction-foncée', 'filtre', 'immersion', 'capsule', 'decaf',
        ];

        $tags = collect($tagNames)->map(fn ($name) => Tag::create(['name' => $name]));

        // Sample posts with real coffee content
        $postsData = [
            [
                'title'        => 'L\'Éthiopie, berceau du café : voyage dans la région de Yirgacheffe',
                'slug'         => 'ethiopie-yirgacheffe-berceau-cafe',
                'excerpt'      => 'Découvrez comment une province montagnarde d\'Éthiopie a façonné le café tel que nous le connaissons aujourd\'hui.',
                'body'         => '<p>La région de Yirgacheffe, perchée à plus de 1 800 mètres d\'altitude dans le sud de l\'Éthiopie, est unanimement reconnue comme l\'une des origines les plus singulières du monde du café specialty. Ses grains offrent une complexité aromatique hors du commun : fleurs blanches, bergamote, thé vert et une acidité lumineuse qui surprend même les palais avertis.</p><p>Contrairement aux caféiers cultivés en plantation, les arbres éthiopiens poussent souvent en forêt semi-sauvage, sous couvert d\'arbres d\'ombrage. Cette méthode dite "jardin forestier" préserve la biodiversité génétique du caféier arabica et confère aux grains une personnalité incomparable.</p><p>La récolte, entièrement manuelle, a lieu entre novembre et janvier. Les cerises rouges sont sélectionnées une à une, puis généralement traitées par voie naturelle : étalées sur des lits africains, elles sèchent au soleil pendant trois à six semaines. Ce procédé développe des notes de fruits confits, de vin et de chocolat noir très caractéristiques.</p><p>Pour valoriser un Yirgacheffe en tasse, favorisez les méthodes douces comme le V60, le Chemex ou la Kalita Wave, avec une température d\'eau entre 90 et 93 °C. Un ratio de 1:15 (café:eau) révèle toute la finesse florale du grain.</p>',
                'category_id'  => $categories[0]->id,
                'published_at' => now()->subDays(10),
                'tag_ids'      => [$tags->firstWhere('name', 'arabica')->id, $tags->firstWhere('name', 'éthiopie')->id, $tags->firstWhere('name', 'single-origin')->id, $tags->firstWhere('name', 'specialty')->id],
            ],
            [
                'title'        => 'Maîtriser l\'espresso : les paramètres clés pour une extraction parfaite',
                'slug'         => 'maitriser-espresso-parametres-extraction',
                'excerpt'      => 'Dose, mouture, température, temps d\'extraction : tout ce que vous devez ajuster pour un espresso remarquable.',
                'body'         => '<p>L\'espresso reste la référence absolue en matière de café concentré. Sa préparation exige rigueur, répétabilité et une compréhension fine de chaque paramètre d\'extraction. Voici les variables à maîtriser.</p><h2>La dose</h2><p>Pour un double espresso, utilisez entre 17 et 20 grammes de café moulu selon votre panier et votre recette. Tassez fermement et uniformément pour éviter les canaux préférentiels.</p><h2>La mouture</h2><p>C\'est le paramètre le plus sensible. Une mouture trop fine ralentit l\'extraction et génère de l\'amertume ; trop grosse, elle accélère le débit et donne un espresso plat et acide. Visez un temps d\'extraction de 25 à 30 secondes pour un ratio 1:2 (18 g de café pour 36 g en tasse).</p><h2>La température</h2><p>Entre 90 et 94 °C selon le profil du grain. Les cafés légers apprécient une température haute (93-94 °C) pour mieux extraire les arômes délicats, tandis que les torréfactions foncées s\'équilibrent mieux autour de 90-91 °C.</p><h2>La pression</h2><p>La majorité des machines de café classiques opèrent à 9 bars de pression. Certains torréfacteurs specialty recommandent aujourd\'hui des profils de pression décroissante (de 9 à 6 bars en fin d\'extraction) pour adoucir la perception d\'amertume.</p>',
                'category_id'  => $categories[1]->id,
                'published_at' => now()->subDays(5),
                'tag_ids'      => [$tags->firstWhere('name', 'espresso')->id, $tags->firstWhere('name', 'specialty')->id],
            ],
            [
                'title'        => 'Le cupping : apprendre à déguster le café comme un professionnel',
                'slug'         => 'cupping-deguster-cafe-professionnel',
                'excerpt'      => 'Le cupping est la méthode universelle d\'évaluation sensorielle du café. Voici comment le pratiquer chez vous.',
                'body'         => '<p>Le cupping, ou dégustation professionnelle du café, est une pratique standardisée par la Specialty Coffee Association (SCA). Elle permet de comparer objectivement des origines, des torréfactions ou des méthodes de traitement en neutralisant les variables liées à la préparation.</p><h2>Matériel nécessaire</h2><p>Des bols de 200 à 300 ml, une balance de précision, un chronomètre, une cuillère à cupping (plus profonde et ronde qu\'une cuillère classique), de l\'eau filtrée chauffée à 93 °C et bien sûr, plusieurs cafés à comparer.</p><h2>Le protocole SCA</h2><p>Moudre 8,25 g de café par 150 ml d\'eau, à une granulométrie grossière similaire à un café filtre. Verser l\'eau sur le marc et laisser infuser 4 minutes. Une croûte se forme en surface : brisez-la en effectuant trois rotations de cuillère vers vous. Sniffez les arômes libérés, écumez les résidus, laissez refroidir 8 à 10 minutes puis aspirez bruyamment (le "slurp") pour projeter le café sur toute la langue.</p><h2>Ce que vous évaluez</h2><p>Arômes, saveur, arrière-goût, acidité, corps, équilibre, uniformité, propreté de tasse et douceur. Chaque critère est noté de 0 à 10. Un café qui dépasse 80 points est considéré comme "specialty".</p>',
                'category_id'  => $categories[2]->id,
                'published_at' => now()->subDays(2),
                'tag_ids'      => [$tags->firstWhere('name', 'specialty')->id, $tags->firstWhere('name', 'arabica')->id],
            ],
            [
                'title'        => 'V60 vs Chemex : quelle méthode filtre choisir ?',
                'slug'         => 'v60-vs-chemex-methode-filtre-choisir',
                'excerpt'      => 'Deux icônes du café filtre face à face. Comprendre leurs différences pour choisir la méthode qui correspond à votre palais.',
                'body'         => '<p>Le V60 de Hario et le Chemex de Peter Schlumbohm sont devenus des symboles du mouvement specialty coffee. Ils partagent le principe de la percolation par gravité, mais produisent des profils de tasse sensiblement différents.</p><h2>Le V60</h2><p>Son filtre côtelé et son ouverture large à la base permettent un débit d\'eau rapide. Le résultat est un café vif, expressif, qui met en valeur l\'acidité et les arômes les plus fins du grain. Le V60 est exigeant : il amplifie les erreurs de mouture ou de technique de versé.</p><h2>Le Chemex</h2><p>Son filtre épais (20 à 30 % plus épais qu\'un filtre V60) retient davantage d\'huiles et de fines particules. La tasse obtenue est plus propre, plus douce, avec moins d\'acidité perceptible. Le Chemex est plus indulgent et très polyvalent. Son design en verre borosilicaté permet de servir directement à table.</p><h2>Lequel choisir ?</h2><p>Si vous appréciez les cafés floraux, acidulés et complexes et que vous aimez affiner votre technique de versé : optez pour le V60. Si vous recherchez une expérience accessible, une tasse propre et équilibrée, idéale pour les cafés de corps moyen : le Chemex est fait pour vous.</p>',
                'category_id'  => $categories[1]->id,
                'published_at' => now()->subDays(1),
                'tag_ids'      => [$tags->firstWhere('name', 'v60')->id, $tags->firstWhere('name', 'chemex')->id, $tags->firstWhere('name', 'filtre')->id],
            ],
        ];

        foreach ($postsData as $data) {
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);

            $post = Post::create(array_merge($data, ['user_id' => $admin->id]));
            $post->tags()->sync($tagIds);

            // Add a sample approved comment
            Comment::create([
                'post_id'    => $post->id,
                'guest_name' => 'Marie Dupont',
                'guest_email'=> 'marie@example.com',
                'body'       => 'Excellent article, tres instructif ! Merci pour ces details.',
                'approved'   => true,
            ]);
        }
    }
}
