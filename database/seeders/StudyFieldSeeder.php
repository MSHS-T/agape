<?php

namespace Database\Seeders;

use App\Models\StudyField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            ["Aéronautique - Espace", ""],
            ["Agriculture - Agronomie", ""],
            ["Aménagement du territoire", ""],
            ["Anthropologie", ""],
            ["Archéologie", ""],
            ["Arts", ""],
            ["Automatique", ""],
            ["Biologie", ""],
            ["Biotechnologies", ""],
            ["Chimie", ""],
            ["Construction - Urbanisme", ""],
            ["Démographie", ""],
            ["Droit", ""],
            ["Economie", ""],
            ["Economie - Econométrie", ""],
            ["Education - Formation - Didactique", ""],
            ["Electronique - Génie électrique", ""],
            ["Energétique", ""],
            ["Environnement", ""],
            ["Ethnologie", ""],
            ["Etudes environnementales", ""],
            ["Finances", ""],
            ["Génie chimique - Génie des procédés", ""],
            ["Génie industriel", ""],
            ["Génie mécanique", ""],
            ["Géographie - Aménagement", ""],
            ["Géographie physique", ""],
            ["Géographie sociale", ""],
            ["Géographie urbaine", ""],
            ["Histoire", ""],
            ["Histoire - Histoire des Arts - Archéologie", ""],
            ["Histoire de l'Art", ""],
            ["Histoire des idées", ""],
            ["Information Communication", ""],
            ["Informatique", ""],
            ["Interaction Homme-Machine", ""],
            ["Langues", ""],
            ["Littérature", ""],
            ["Management - Gestion d’entreprise", ""],
            ["Matériaux", ""],
            ["Mathématiques", ""],
            ["Mécanique", ""],
            ["Médecine", ""],
            ["Météorologie", ""],
            ["Optique", ""],
            ["Pharmacie", ""],
            ["Philosophie", ""],
            ["Physique", ""],
            ["Préhistoire", ""],
            ["Psychologie", ""],
            ["Religion", ""],
            ["Robotique", ""],
            ["Sciences cognitives", ""],
            ["Sciences de l'éducation", ""],
            ["Sciences de l'univers", ""],
            ["Sciences de la terre", ""],
            ["Sciences de la vie", ""],
            ["Sciences du langage", ""],
            ["Sciences politiques", ""],
            ["Sciences vétérinaires", ""],
            ["Sociologie", ""],
            ["STAPS", ""],
            ["Technologies", ""],
            ["Télécommunications", ""],
        ];
        foreach ($values as $value) {
            StudyField::create([
                'name'       => ["fr" => $value[0], "en" => $value[1]],
                'creator_id' => null,
            ]);
        }
    }
}
