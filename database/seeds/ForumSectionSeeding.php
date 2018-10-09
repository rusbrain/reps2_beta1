<?php

use Illuminate\Database\Seeder;

class ForumSectionSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forum_sections = [
            [ 'position' => '1', 'reps_id' => 1, 'name' => 'all', 'title' => 'Общий', 'description' => 'Обсуждение самых разнообразных тем', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '2', 'reps_id' => null, 'name' => 'columns', 'title' => 'Колонки', 'description' => 'none', 'is_general'=> 1, 'user_can_add_topics'=> 0],
            [ 'position' => '4', 'reps_id' => null, 'name' => 'interview', 'title' => 'Интервью', 'description' => 'none', 'is_general'=> 1, 'user_can_add_topics'=> 0],
            [ 'position' => '5', 'reps_id' => null, 'name' => 'article', 'title' => 'Статьи', 'description' => 'none', 'is_general'=> 1, 'user_can_add_topics'=> 0],
            [ 'position' => '6', 'reps_id' => 3, 'name' => 'strategy', 'title' => 'Стратегии', 'description' => 'Обсуждение стратегий, помощь начинающим и не только', 'is_general'=> 1, 'user_can_add_topics'=> 1],
            [ 'position' => '7', 'reps_id' => null, 'name' => 'coverage', 'title' => 'Репортажи', 'description' => 'none', 'is_general'=> 1, 'user_can_add_topics'=> 0],
            [ 'position' => '3', 'reps_id' => 8, 'name' => 'event', 'title' => 'Чемпионаты', 'description' => 'Здесь вы можете сообщить об вашем чемпионате и о его результатах. Так же здесь вы можете вести прямой репортаж с корейских, и не только, лиг или других мероприятий.', 'is_general'=> 1, 'user_can_add_topics'=> 1],
            [ 'position' => '8', 'reps_id' => 4, 'name' => 'clans', 'title' => 'Кланы', 'description' => 'Здесь вы можите найти себе новый клан, договориться о тренировках, договориться о клан-варе или разместить новость вашего клана', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '9', 'reps_id' => 9, 'name' => 'vod', 'title' => 'Всё о VOD\'ах', 'description' => 'Здесь вы можете выложить линк на VOD или попросить найти нужный вам VOD. О том как добавить вод читайте инструкцию в анонсе.', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '10', 'reps_id' => 10, 'name' => 'humor', 'title' => 'Юмор', 'description' => 'Есть интересные рассказы, картинки или другая весёлая информация? Пишите и давайте веселиться ^___________^', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '11', 'reps_id' => 13, 'name' => 'music_and_video', 'title' => 'Музыка и Видео', 'description' => 'Обсуждение музыки и видео. Новинки, мнения о фильмах, группах и т.д.', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '12', 'reps_id' => 14, 'name' => 'help', 'title' => 'Помощь', 'description' => 'Все вопросы только здесь.', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '13', 'reps_id' => 15, 'name' => 'star_craft_2', 'title' => 'StarCraft II', 'description' => 'Обсуждение StarCraft II', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '13', 'reps_id' => 16, 'name' => 'poker', 'title' => 'Покер', 'description' => 'Где, Что, Как и Сколько!', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '13', 'reps_id' => 17, 'name' => 'politics', 'title' => 'Политика', 'description' => 'Кого, Когда и Почему!!!', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '13', 'reps_id' => 18, 'name' => 'business', 'title' => 'Бизнес', 'description' => 'Хаха, зачем тебе это? Это не приносит денег', 'is_general'=> 0, 'user_can_add_topics'=> 1],
            [ 'position' => '13', 'reps_id' => 19, 'name' => 'games', 'title' => 'Игры', 'description' => 'Игры, кроме Starcraft', 'is_general'=> 0, 'user_can_add_topics'=> 1],
        ];

        \App\ForumSection::insert($forum_sections);
    }
}
