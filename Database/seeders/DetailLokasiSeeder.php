<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailLokasiSeeder extends Seeder
{
    public function run()
    {
        $detailLokasi = [
            ['name' => 'rak_a_a1_a25', 'label' => 'Area Rak A (A1-A25)', 'category' => 'Childpart Area'],
            ['name' => 'rak_a_a26_a52', 'label' => 'Area Rak A (A26-A52)', 'category' => 'Childpart Area'],
            ['name' => 'rak_b_b1_b25', 'label' => 'Area Rak B (B1-B25)', 'category' => 'Childpart Area'],
            ['name' => 'rak_b_b26_b54', 'label' => 'Area Rak B (B26-B54)', 'category' => 'Childpart Area'],
            ['name' => 'rak_c_c1_c25', 'label' => 'Area Rak C (C1-C25)', 'category' => 'Childpart Area'],
            ['name' => 'rak_c_c26_c50', 'label' => 'Area Rak C (C26-C50)', 'category' => 'Childpart Area'],
            ['name' => 'rak_d_d1_d25', 'label' => 'Area Rak D (D1-D25)', 'category' => 'Childpart Area'],
            ['name' => 'rak_d_d26_d50', 'label' => 'Area Rak D (D26-D50)', 'category' => 'Childpart Area'],
            ['name' => 'rak_e_e1_e25', 'label' => 'Area Rak E (E1-E25)', 'category' => 'Childpart Area'],
            ['name' => 'rak_e_e26_e50', 'label' => 'Area Rak E (E26-E50)', 'category' => 'Childpart Area'],
            ['name' => 'rak_f_f1_f25', 'label' => 'Area Rak F (F1-F25)', 'category' => 'Childpart Area'],
            ['name' => 'rak_f_f26_f50', 'label' => 'Area Rak F (F26-F50)', 'category' => 'Childpart Area'],
            ['name' => 'rak_packing', 'label' => 'Area Packanging YPC', 'category' => 'Pakaging Area'],
            ['name' => 'rak_packing', 'label' => 'Area Packanging Carton Box WH(2)', 'category' => 'Pakaging Area'],
            ['name' => 'rak_packing', 'label' => 'Area Packanging Carton Box WH(3)', 'category' => 'Pakaging Area'],
            ['name' => 'rak_finished_good_01', 'label' => 'Area Finished Good WH (11.1)', 'category' => 'Finished Good Area'],
            ['name' => 'rak_finished_good_02', 'label' => 'Area Finished Good WH (11.2)', 'category' => 'Finished Good Area'],
            ['name' => 'rak_finished_good_03', 'label' => 'Area Finished Good WH (11.3)', 'category' => 'Finished Good Area'],
            ['name' => 'rak_finished_good_04', 'label' => 'Area Shutter FG, Prep MMKI (12.1)', 'category' => 'Finished Good Area'],
            ['name' => 'rak_finished_good_05', 'label' => 'Area Shutter FG, Prep MMKI (12.2)', 'category' => 'Finished Good Area'],
            ['name' => 'rak_subcont_wip', 'label' => 'Area Subcont FG', 'category' => 'Area Subcont'],
            ['name' => 'rak_subcont_wip', 'label' => 'Area Subcont WIP', 'category' => 'Area Subcont'],
            ['name' => 'rak_delivery', 'label' => 'Area Delivery', 'category' => 'Area Delivery'],
            ['name' => 'rak_material', 'label' => 'Area Material Transit', 'category' => 'Material Transit'],
            ['name' => 'rak_material', 'label' => 'Area Matrial WorkShop', 'category' => 'Material Transit'],
            ['name' => 'rak_shutter_01', 'label' => 'Area Shutter FG Fin Line 1-23 (16.1)', 'category' => 'Shutter FG Fin'],
            ['name' => 'rak_shutter_02', 'label' => 'Area Shutter FG Fin Line 1-23 (16.2)', 'category' => 'Shutter FG Fin'],
            ['name' => 'rak_shutter_03', 'label' => 'Area Shutter FG Fin Line 1-23 (16.3)', 'category' => 'Shutter FG Fin'],
            ['name' => 'rak_qc_wip', 'label' => 'Area WIP QC Office', 'category' => 'QC Office Room'],
            ['name' => 'rak_qc_fg', 'label' => 'Area FG QC Office', 'category' => 'QC Office Room'],
            ['name' => 'rak_manufacture_FG', 'label' => 'Area Office FG', 'category' => 'Manufacture Office'],
            ['name' => 'rak_manufacture_WIP', 'label' => 'Area Office WIP', 'category' => 'Manufacture Office'],
            ['name' => 'rak_wip_fin_01', 'label' => 'Area Produksi (Finishing) WIP', 'category' => 'WIP Lin Fin'],
            ['name' => 'rak_childpart_fin_01', 'label' => 'Area Childpart Fin Line (1-10)', 'category' => 'Childpart Fin'],
            ['name' => 'rak_childpart_fin_02', 'label' => 'Area Childpart Fin Line (11-20)', 'category' => 'Childpart Fin'],
            ['name' => 'rak_childpart_fin_01', 'label' => 'Area Childpart Fin Line (21-30)', 'category' => 'Childpart Fin'],
            ['name' => 'rak_wip_shutter_01', 'label' => 'Area WIP Shutter Molding 1-30 (21.1)', 'category' => 'WIP Shutter Molding'],
            ['name' => 'rak_wip_shutter_02', 'label' => 'Area WIP Shutter Molding 1-30 (21.2)', 'category' => 'WIP Shutter Molding'],
            ['name' => 'rak_wip_shutter_03', 'label' => 'Area WIP Shutter Molding 32-59 (21.3)', 'category' => 'WIP Shutter Molding'],
            ['name' => 'rak_wip_shutter_04', 'label' => 'Area WIP Shutter Molding 32-59 (21.4)', 'category' => 'WIP Shutter Molding'],
            ['name' => 'rak_wip_pianica_01', 'label' => 'Area WIP Pianca (23.1)', 'category' => 'WIP Pianica'],
            ['name' => 'rak_wip_pianica_02', 'label' => 'Area WIP Pianca (23.2)', 'category' => 'WIP Pianica'],
            ['name' => 'rak_wip_wh2_01', 'label' => 'Area WIP WH 2 (24.1)', 'category' => 'WIP WH 2'],
            ['name' => 'rak_wip_wh2_02', 'label' => 'Area WIP WH 2 (24.2)', 'category' => 'WIP WH 2'],
            ['name' => 'rak_wip_molding', 'label' => 'Area WIP Molding', 'category' => 'WIP Molding'],
            ['name' => 'rak_material_molding_01', 'label' => 'Area Material Line Molding V', 'category' => 'Material Molding'],
            ['name' => 'rak_material_molding_02', 'label' => 'Area Material Line Molding F', 'category' => 'Material Molding'],
            ['name' => 'rak_material_molding_03', 'label' => 'Area Material Line Funsai Mix', 'category' => 'Material Molding'],
            ['name' => 'rak_wip_daisha_01', 'label' => 'Area WIP Rak Daisha (27.1)', 'category' => 'WIP Rak Daisha'],
            ['name' => 'rak_wip_daisha_02', 'label' => 'Area WIP Rak Daisha (27.2)', 'category' => 'WIP Rak Daisha'],
            ['name' => 'rak_service_part', 'label' => 'Area SPD', 'category' => 'Area Service Part'],
            ['name' => 'rak_Off_Deliver', 'label' => 'Area Cut Off Delivery', 'category' => 'Cut Off Delivery'],
        ];

        DB::table('detail_lokasi')->insert($detailLokasi);
    }
}
