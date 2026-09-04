<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@cinema.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
                'is_admin' => true,
            ]
        );

        $movies = [
            ['title' => 'Inception', 'description' => 'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.', 'release_year' => 2010, 'rating' => 8.8],
            ['title' => 'The Dark Knight', 'description' => 'When the menace known as the Joker wreaks havoc on Gotham, Batman must accept one of the greatest psychological tests of his ability to fight injustice.', 'release_year' => 2008, 'rating' => 9.0],
            ['title' => 'Interstellar', 'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.', 'release_year' => 2014, 'rating' => 8.6],
            ['title' => 'The Matrix', 'description' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', 'release_year' => 1999, 'rating' => 8.7],
            ['title' => 'Parasite', 'description' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.', 'release_year' => 2019, 'rating' => 8.5],
            ['title' => 'Gladiator', 'description' => 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.', 'release_year' => 2000, 'rating' => 8.5],
            ['title' => 'The Shawshank Redemption', 'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'release_year' => 1994, 'rating' => 9.3],
            ['title' => 'Pulp Fiction', 'description' => 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.', 'release_year' => 1994, 'rating' => 8.9],
            ['title' => 'Fight Club', 'description' => 'An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into something much more.', 'release_year' => 1999, 'rating' => 8.8],
            ['title' => 'Forrest Gump', 'description' => 'The presidencies of Kennedy and Johnson, the Vietnam War, and other historical events unfold through the perspective of an Alabama man.', 'release_year' => 1994, 'rating' => 8.8],
            ['title' => 'The Godfather', 'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 'release_year' => 1972, 'rating' => 9.2],
            ['title' => 'Whiplash', 'description' => 'A promising young drummer enrolls at a cutthroat music conservatory where his dreams are mentored by an instructor who will stop at nothing.', 'release_year' => 2014, 'rating' => 8.5],
            ['title' => 'Avengers: Endgame', 'description' => 'After the devastating events of Infinity War, the Avengers assemble once more to reverse Thanos\' actions and restore balance to the universe.', 'release_year' => 2019, 'rating' => 8.4],
            ['title' => 'Joker', 'description' => 'A mentally troubled stand-up comedian embarks on a downward spiral that leads to the creation of an iconic villain.', 'release_year' => 2019, 'rating' => 8.4],
            ['title' => 'La La Land', 'description' => 'A jazz pianist falls for an aspiring actress in Los Angeles while both pursue their dreams in a city known for crushing them.', 'release_year' => 2016, 'rating' => 8.0],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}