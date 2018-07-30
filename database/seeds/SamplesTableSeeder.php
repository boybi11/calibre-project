<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SamplesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('samples')->insert(
        	[
	            'name' => 'Riou',
	            'range' => 'M',
	            'runes' => 'Bright Shield Rune, Darkness Rune, Blue Gate Rune',
	            'embedded_rune' => 'Kindness Rune',
	            'evaluation' => "He's the hero of the game, so you'll know him better than anyone else.  He's good offensively and defensively.  He's fast and has the Bright Shield Rune, which is great for healing your party members.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Tir McDohl',
	            'range' => 'M',
	            'runes' => 'Rage Rune, Soul Eater, Flowing Rune',
	            'embedded_rune' => 'Poison/Down Rune',
	            'evaluation' => "He's as good as he was before, if not better.  Tir is back, but only if you load a completed Suikoden I file.  There's a nice FAQ about it here at GameFAQs.  Anyways, the Soul Eater might be a rival for the best rune in the game.  And in the hands of Tir, you'll have a hugely destructive party member.  Otherwise, all of his stats are extremely high and his Double Leader Unite attack with Riou is also incredibly powerful.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Kahn',
	            'range' => 'M',
	            'runes' => 'Darkness Rune, Resurrection Rune, Flowing Rune',
	            'embedded_rune' => 'Magic Drain Rune',
	            'evaluation' => "Kahn is one of the best fighters in the game.  He's got all the bases covered, three runes, and lot of HP and MP.  Make sure you give him your best runes, such as a Flowing Rune.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Sierra',
	            'range' => 'S',
	            'runes' => 'Mother Earth Rune, Darkness Rune',
	            'embedded_rune' => 'Thunder Rune',
	            'evaluation' => "Her weapon isn't as sharp as it could be.  But still, she's probably going to do some spell casting, anyways.  Lots of MP and two rune slots are nice.  High stats give her a higher standing, too.  She's definitely one of the best in the game.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Nina',
	            'range' => 'M',
	            'runes' => 'Lightning Rune, Fire Rune',
	            'embedded_rune' => 'Water Rune',
	            'evaluation' => "Wow, Nina was the character I'd least expect to be in this class of characters.  But she's very well-rounded and has high stats overall. She's got a lot of MP, Strength, and Defense, too.  I guess that Nina is an Easter Egg that the designers threw in.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Sigfried',
	            'range' => 'M',
	            'runes' => 'Lightning Rune, White Saint Rune, ????????',
	            'embedded_rune' => 'None',
	            'evaluation' => "His gender isn't quite known.  Richmond refers to him as a 'he,'but when you take a bath with him, he's in the girls' side.  I'll just say that he's male, but he likes his women.  His attack power is through the roof and he has a unique rune alongside that.  But, due to his large animal status, you might replace him for two other strong magicians instead. Stat-wise, he has no major problems, but he's a little weak on the physical defense side.  Also, if he gets a critical hit, he not only stabs the enemy, but he pummels it with his front hooves.  It should result in around 1300+ damage.  On a side note, he gets a third rune slot sometime between level 60 and level 99.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Zamza',
	            'range' => 'S',
	            'runes' => 'Fire Dragon Rune, Fire Sealing Rune',
	            'embedded_rune' => 'Fire Lizard Rune',
	            'evaluation' => "As much as I hate to admit it, he's actually a good fighter. He's much like Siegfried, only with less attack and more defense.  He's a good magician, but you might want to equip him with a Fire Sealing Rune to compliment his Fire Dragon Rune.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Flik',
	            'range' => 'S',
	            'runes' => 'Thunder Rune, Rage Rune',
	            'embedded_rune' => 'Exertion Rune',
	            'evaluation' => "Flik will serve you well throughout the game.  His high MP and high stats all-around make him a steady party member.  Replace his Lightning Rune and give him a Thunder and Rage Rune if you find some.  He'll be an offensive machine.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Sheena',
	            'range' => 'S',
	            'runes' => 'Thunder Rune, Earth Rune, Fire Rune',
	            'embedded_rune' => 'Down Rune',
	            'evaluation' => "He has high stats in every area, and if you transferred him in from Suikoden I, he'll have a sharp weapon and high level.  He gets 3 runes, but his magical power is lower than other magic users.  So, his magic attack strength isn't as strong as some of the other people's magic strength.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Camus',
	            'range' => 'S',
	            'runes' => 'Rage Rune, Resurrection Rune',
	            'embedded_rune' => 'None',
	            'evaluation' => "He gets more spells and is the better magically than Miklotov. He's weaker physically, though, and can only get two runes.  His Rage Rune is a good compliment, though, and could very well combine with a Thunder Rune.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Anita',
	            'range' => 'S',
	            'runes' => 'Falcon Rune, Water Rune',
	            'embedded_rune' => 'Down Rune',
	            'evaluation' => "She has high stats in all areas.  None are astronomical, but high nonetheless.  I gave her a Water Rune so she does some damage with her Falcon Rune and heals when the party is low on HP.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Tengaar',
	            'range' => 'L',
	            'runes' => 'Lightning Rune, Mother Earth Rune',
	            'embedded_rune' => 'Wind Rune',
	            'evaluation' => "Although her HP is kinda low, her MP is quite high.  Give her a Mother Earth Rune and she'll be a good back-up support magician.  Give her a Lightning Rune and she'll have good offensive strength as well.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Eilie',
	            'range' => 'L',
	            'runes' => 'Fire Rune, Darkness Rune',
	            'embedded_rune' => 'Lightning Rune',
	            'evaluation' => "Eilie gets a bit of MP if you level her up enough.  It's not as much as some of the more magical people, but she still is a useful character. She's got high stats in all areas, and she's good offensively and defensively.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Luc',
	            'range' => 'S',
	            'runes' => 'Blue Gate Rune, Wind Rune, Darkness Rune',
	            'embedded_rune' => 'Wind Rune',
	            'evaluation' => "Luc is a good character early on in the game.  He's got a weak defense and offense, so he does best in the back row.  Give him a Blue Gate Rune when you first get him (before Two River) and give it to Riou once he reaches level 40.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Mazus',
	            'range' => 'S',
	            'runes' => 'Blue Gate Rune, Thunder Rune, Wizard Rune',
	            'embedded_rune' => 'Lightning Rune',
	            'evaluation' => "Mazus is probably the second strongest Full-Fledged Magician on the offensive side.  He has high HP and Strength.  He is very weak offensively, though.  Keep him in the back row and have him cast spells until the battle is over.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Viki',
	            'range' => 'S',
	            'runes' => 'Lightning Rune, Blinking Rune',
	            'embedded_rune' => 'Earth Rune',
	            'evaluation' => "Even though she's not the brightest character in the world, she does have some strong magic skills.  She even has a unique Blinking Rune, which is quite rare.  You can get another Blinking Rune in Rokkaku, though, so it's not totally unique.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Viktor',
	            'range' => 'S',
	            'runes' => 'Double-Beat Rune, Fury Rune',
	            'embedded_rune' => 'Friendship Rune',
	            'evaluation' => "Ahh, Viktor.  Get personality and his fighting ability matches it.  Early in the game, get a Double-Beat Rune from the Cut Rabbits in the North Sparrow Pass.  Once you have access to the Highland Garrison north of Muse, make sure you buy a Fury Rune from the Muse Runemaster.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Pesmerga',
	            'range' => 'S',
	            'runes' => 'Killer, Double-Beat, Fury Rune',
	            'embedded_rune' => 'Rage Rune',
	            'evaluation' => "First off, replace that wimpy Counter Rune with a more powerful rune.  A Killer Rune would be nice, and you can get one from either Tai-Ho or the Woodpeckers in the passage to Tsai's house.  Now, you can do some serious damage.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Georg',
	            'range' => 'S',
	            'runes' => 'Killer Rune',
	            'embedded_rune' => 'Down Rune',
	            'evaluation' => "Georg was a favorite of mine when I first played the game.  He did quite well in Rockaxe and later.  I did some Richmond investigations and found out that he's got quite a history behind him.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'L. C. Chan',
	            'range' => 'S',
	            'runes' => 'None',
	            'embedded_rune' => 'None',
	            'evaluation' => "An interesting thing about Wakaba and Long Chan-Chan is that their MP acquisition pattern is different from all of the other characters. They get as much MP as if they had a Magic stat of 100, but their stats are at 50+.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Nanami',
	            'range' => 'M',
	            'runes' => 'Water Rune, Balance/Spark Rune',
	            'embedded_rune' => 'Earth Rune',
	            'evaluation' => "Throughout the game, you'll have to have Nanami as a party member.  But, her MP is not as high as it should be, and when she really starts to get some MP, it becomes obsolete due to story purposes.  She's got some good stats in the other areas, but more or less she's a much weaker version of Riou.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Sasuke',
	            'range' => 'L',
	            'runes' => 'Killer Rune',
	            'embedded_rune' => 'Sleep Rune',
	            'evaluation' => "He's got a ton of Speed and Technique, so he's fast, dodges well, and always seems to get a hit.  His Killer rune also allows him to get critical hits all the time.  But, he's limited to just one rune slot.  But still, he's a really good fighter.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Shiro',
	            'range' => 'S',
	            'runes' => 'Counter Rune',
	            'embedded_rune' => 'None',
	            'evaluation' => "ell, all of his stats are quite high.  But, due to his animal status, he can't equip weapons nor armor.  He has a lower HP than others, but his MP is high enough that he can cast a level 4 spell.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Clive',
	            'range' => 'L',
	            'runes' => 'Kite Rune',
	            'embedded_rune' => 'Fire Rune',
	            'evaluation' => "Clive isn't very much different from his Suikoden I counterpart. His level will be greatly reduced from your S1 file, starting around level 20.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Stallion',
	            'range' => 'L',
	            'runes' => "True Holy Rune, Champion's Rune",
	            'embedded_rune' => 'Sleep Rune',
	            'evaluation' => " give Stallion the Champion's Rune that you get in L'Renouille. That way, you can put him in your party and go wherever you need to go.  The trip to Sajah will go much faster with this combination.  Average fighter overall.  Excellent Speed.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Simone',
	            'range' => 'L',
	            'runes' => 'Wind Rune',
	            'embedded_rune' => 'Earth Rune',
	            'evaluation' => "Although he has a lot of MP, his low HP, Defense, Attack and one-rune limit bring him down to the Average Fighter class.  He's pretty bland if you ask me.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Tuta',
	            'range' => 'L',
	            'runes' => 'Chimera Rune, Medicine Rune',
	            'embedded_rune' => 'Earth Rune',
	            'evaluation' => "Make sure to embed an earth rune on his weapon.  It'll give some extra defense which he desperately needs.  A super-low HP count as well as almost no power makes him a person you will never choose unless you want a challenge.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Hai Yo',
	            'range' => 'S',
	            'runes' => 'Hazy Rune, Barrier Rune, ?????????',
	            'embedded_rune' => 'Down Rune',
	            'evaluation' => "Most of the good stats border around 100, which is not very good. Two rune are nice, but Hai Yo is best left in the kitchen.  Also, he gets a third rune slot between level 60 and level 99.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Mukumuku',
	            'range' => 'L',
	            'runes' => 'Fire Rune',
	            'embedded_rune' => 'None',
	            'evaluation' => "Pretty average in most areas, but he has a low HP and magical prowess.  He's like all of the other squirrels, is not a good party member. His only usefulness is to recruit him in Kyaro Town to make those battles much easier due to your lack of characters.",
	            'image' => '',
        	]
        );
        DB::table('samples')->insert(
        	[
	            'name' => 'Chuchara',
	            'range' => 'S',
	            'runes' => 'Barrier Rune',
	            'embedded_rune' => 'None',
	            'evaluation' => "These stats may not be accurate, as I imported Chuchara via a Codebreaker.  If they ARE accurate, Chuchara is probably the weakest character in the game.  But then, after boosting his level to 99, take a look at his stats.",
	            'image' => '',
        	]
        );
    }
}
