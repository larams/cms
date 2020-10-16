<?php

use Illuminate\Database\Seeder;

class StructureTypeSeeder extends Seeder {

    public function run()
    {
        DB::table('structure_types')->delete();

        DB::table('structure_types')->insert( array('id' => 1, 'name' => 'site', 'handler' => 'site', 'name_lang' => 'Puslapis'));
        DB::table('structure_types')->insert( array('id' => 2, 'name' => 'site_lang', 'handler' => 'site_lang', 'name_lang' => 'Puslapio kalba'));
        DB::table('structure_types')->insert( array('id' => 4, 'name' => 'cms.media_file_version', 'handler' => 'site', 'name_lang' => 'Bylos versija'));
        DB::table('structure_types')->insert( array('id' => 5, 'name' => 'cms.media_file', 'handler' => 'empty', 'name_lang' => 'Byla'));
        DB::table('structure_types')->insert( array('id' => 6, 'name' => 'cms.media_folder', 'handler' => 'empty', 'name_lang' => 'Katalogas'));
        DB::table('structure_types')->insert( array('id' => 9, 'name' => 'text', 'handler' => 'text', 'name_lang' => 'Tekstinis puslapis'));
        DB::table('structure_types')->insert( array('id' => 11, 'name' => 'main_menu', 'handler' => 'empty', 'name_lang' => 'Pagrindinis meniu'));
        DB::table('structure_types')->insert( array('id' => 17, 'name' => 'cms.gallery', 'handler' => 'empty', 'name_lang' => 'Papildomas meniu'));
        DB::table('structure_types')->insert( array('id' => 21, 'name' => 'sub_menu', 'handler' => 'empty', 'name_lang' => 'Media katalogas'));
        DB::table('structure_types')->insert( array('id' => 48, 'name' => 'empty', 'handler' => 'empty', 'name_lang' => 'Meniu punktas'));


        DB::table('structure_types_relations')->insert( array('type_id' => 1, 'rel_type_id' => 2));
        DB::table('structure_types_relations')->insert( array('type_id' => 2, 'rel_type_id' => 11));
        DB::table('structure_types_relations')->insert( array('type_id' => 5, 'rel_type_id' => 4));
        DB::table('structure_types_relations')->insert( array('type_id' => 6, 'rel_type_id' => 5));
        DB::table('structure_types_relations')->insert( array('type_id' => 9, 'rel_type_id' => 9));
        DB::table('structure_types_relations')->insert( array('type_id' => 11, 'rel_type_id' => 9));
        DB::table('structure_types_relations')->insert( array('type_id' => 11, 'rel_type_id' => 48));
        DB::table('structure_types_relations')->insert( array('type_id' => 17, 'rel_type_id' => 6));
        DB::table('structure_types_relations')->insert( array('type_id' => 21, 'rel_type_id' => 9));
        DB::table('structure_types_relations')->insert( array('type_id' => 48, 'rel_type_id' => 9));

    }

}