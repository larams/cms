<?php


use Illuminate\Database\Seeder;

class StructureItemSeeder extends Seeder {

    public function run()
    {
        DB::table('structure_items')->delete();


        $siteId = DB::table('structure_items')->insertGetId( array('parent_id' => DB::raw('NULL'), 'name' => 'Site Name', 'level' => 1, 'type_id' => 1, 'left' => 1, 'right' => 14, 'tree' => 1, 'active' => 1 ) );
        DB::table('structure_items')->insert( array('parent_id' => DB::raw('NULL'), 'name' => 'Galerija', 'level' => 1, 'type_id' => 17, 'left' => 15, 'right' => 16, 'tree' => 1, 'active' => 1 ) );

        $languageId = DB::table('structure_items')->insertGetId( array('parent_id' => $siteId, 'name' => 'EN', 'uri' => 'en', 'level' => 2, 'type_id' => 2, 'left' => 2, 'right' => 7, 'tree' => 1, 'active' => 1 ) );
        DB::table('structure_items')->insert( array('parent_id' => $languageId, 'name' => 'Pagrindinis meniu', 'level' => 3, 'type_id' => 11, 'left' => 3, 'right' => 4, 'tree' => 1, 'active' => 1 ) );
        DB::table('structure_items')->insert( array('parent_id' => $languageId, 'name' => 'Papildomas meniu', 'level' => 3, 'type_id' => 11, 'left' => 5, 'right' => 6, 'tree' => 1, 'active' => 1 ) );
        DB::table('structure_data')->insert( array('item_id' => $languageId, 'name' => 'meta_title', 'data' => '' ));
        DB::table('structure_data')->insert( array('item_id' => $languageId, 'name' => 'meta_description', 'data' => '' ));
        DB::table('structure_data')->insert( array('item_id' => $languageId, 'name' => 'short_code', 'data' => 'en' ));

        $languageId = DB::table('structure_items')->insertGetId( array('parent_id' => $siteId, 'name' => 'LT', 'uri' => 'lt', 'level' => 2, 'type_id' => 2, 'left' => 8, 'right' => 13, 'tree' => 1, 'active' => 1 ) );
        DB::table('structure_items')->insert( array('parent_id' => $languageId, 'name' => 'Pagrindinis meniu', 'level' => 3, 'type_id' => 11, 'left' => 9, 'right' => 10, 'tree' => 1, 'active' => 1 ) );
        DB::table('structure_items')->insert( array('parent_id' => $languageId,'name' => 'Papildomas meniu', 'level' => 3, 'type_id' => 11, 'left' => 11, 'right' => 12, 'tree' => 1, 'active' => 1 ) );
        DB::table('structure_data')->insert( array('item_id' => $languageId, 'name' => 'meta_title', 'data' => '' ));
        DB::table('structure_data')->insert( array('item_id' => $languageId, 'name' => 'meta_description', 'data' => '' ));
        DB::table('structure_data')->insert( array('item_id' => $languageId, 'name' => 'short_code', 'data' => 'lt' ));

    }

}