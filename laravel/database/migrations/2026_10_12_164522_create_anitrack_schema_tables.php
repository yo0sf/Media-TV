<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // 'admin', 'manager', 'user'
            $table->string('name_en');
            $table->string('name_ar');
            $table->timestamps();
        });

        // 2. Add role_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->nullOnDelete();
        });

        // 3. Genres table
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name_en');
            $table->string('name_ar');
            $table->timestamps();
        });

        // 4. Series table
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('synopsis_en');
            $table->text('synopsis_ar');
            $table->enum('type', ['TV', 'Movie', 'OVA'])->default('TV');
            $table->enum('status', ['Airing', 'Finished', 'Upcoming'])->default('Finished');
            $table->unsignedInteger('total_episodes')->default(12);
            $table->unsignedSmallInteger('release_year')->default(2024);
            $table->string('poster_image')->nullable();
            $table->timestamps();
        });

        // 5. Pivot: series_genres
        Schema::create('series_genres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained('series')->cascadeOnDelete();
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
            $table->unique(['series_id', 'genre_id']);
        });

        // 6. Episodes table
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained('series')->cascadeOnDelete();
            $table->unsignedInteger('episode_number');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->date('air_date')->nullable();
            $table->timestamps();
            $table->unique(['series_id', 'episode_number']);
        });

        // 7. Watchlists table
        Schema::create('watchlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('series_id')->constrained('series')->cascadeOnDelete();
            $table->enum('status', ['Watching', 'Completed', 'Plan to Watch', 'On Hold', 'Dropped'])->default('Plan to Watch');
            $table->unsignedInteger('progress_episodes')->default(0);
            $table->timestamps();
            $table->unique(['user_id', 'series_id']);
        });

        // 8. Reviews table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('series_id')->constrained('series')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1 to 10
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
            $table->unique(['user_id', 'series_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('watchlists');
        Schema::dropIfExists('episodes');
        Schema::dropIfExists('series_genres');
        Schema::dropIfExists('series');
        Schema::dropIfExists('genres');
        
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            });
        }

        Schema::dropIfExists('roles');
    }
};
