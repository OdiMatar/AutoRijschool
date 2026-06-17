<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_get_instructeurs_in_dienst;
CREATE PROCEDURE sp_get_instructeurs_in_dienst()
BEGIN
    SELECT Id, Voornaam, Tussenvoegsel, Achternaam,
           TRIM(CONCAT(Voornaam, ' ', IFNULL(CONCAT(Tussenvoegsel, ' '), ''), Achternaam)) AS VolledigeNaam,
           Mobiel, DatumInDienst, AantalSterren
    FROM instructeurs
    WHERE IsActief = 1
    ORDER BY CHAR_LENGTH(AantalSterren) DESC, Achternaam ASC, Voornaam ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_get_voertuigen_bij_instructeur;
CREATE PROCEDURE sp_get_voertuigen_bij_instructeur(IN p_InstructeurId BIGINT UNSIGNED)
BEGIN
    SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof,
           tv.TypeVoertuig, tv.Rijbewijscategorie, vi.DatumToekenning
    FROM voertuigen v
    INNER JOIN voertuig_instructeur vi ON vi.VoertuigId = v.Id
    INNER JOIN type_voertuigen tv ON tv.Id = v.TypeVoertuigId
    WHERE vi.InstructeurId = p_InstructeurId
      AND v.IsActief = 1
      AND vi.IsActief = 1
    ORDER BY tv.Rijbewijscategorie DESC, v.Type ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_get_beschikbare_voertuigen;
CREATE PROCEDURE sp_get_beschikbare_voertuigen()
BEGIN
    SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof,
           tv.TypeVoertuig, tv.Rijbewijscategorie
    FROM voertuigen v
    INNER JOIN type_voertuigen tv ON tv.Id = v.TypeVoertuigId
    LEFT JOIN voertuig_instructeur vi ON vi.VoertuigId = v.Id
    WHERE vi.Id IS NULL
      AND v.IsActief = 1
    ORDER BY tv.Rijbewijscategorie ASC, v.Type ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_get_alle_voertuigen;
CREATE PROCEDURE sp_get_alle_voertuigen()
BEGIN
    SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof,
           tv.TypeVoertuig, tv.Rijbewijscategorie,
           TRIM(CONCAT(i.Voornaam, ' ', IFNULL(CONCAT(i.Tussenvoegsel, ' '), ''), i.Achternaam)) AS InstructeurNaam,
           i.Achternaam AS InstructeurAchternaam,
           vi.Id AS ToewijzingId
    FROM voertuigen v
    INNER JOIN type_voertuigen tv ON tv.Id = v.TypeVoertuigId
    LEFT JOIN voertuig_instructeur vi ON vi.VoertuigId = v.Id AND vi.IsActief = 1
    LEFT JOIN instructeurs i ON i.Id = vi.InstructeurId
    WHERE v.IsActief = 1
    ORDER BY v.Bouwjaar DESC, i.Achternaam DESC, v.Type ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_get_voertuig_edit;
CREATE PROCEDURE sp_get_voertuig_edit(IN p_VoertuigId BIGINT UNSIGNED)
BEGIN
    SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof, v.TypeVoertuigId, vi.InstructeurId
    FROM voertuigen v
    LEFT JOIN voertuig_instructeur vi ON vi.VoertuigId = v.Id
    WHERE v.Id = p_VoertuigId;
END
SQL);

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_update_voertuig;
CREATE PROCEDURE sp_update_voertuig(
    IN p_OrigineleInstructeurId BIGINT UNSIGNED,
    IN p_VoertuigId BIGINT UNSIGNED,
    IN p_Kenteken VARCHAR(10),
    IN p_Type VARCHAR(80),
    IN p_Brandstof VARCHAR(20),
    IN p_TypeVoertuigId BIGINT UNSIGNED,
    IN p_InstructeurId BIGINT UNSIGNED
)
BEGIN
    UPDATE voertuigen
    SET Kenteken = p_Kenteken,
        Type = p_Type,
        Brandstof = p_Brandstof,
        TypeVoertuigId = p_TypeVoertuigId,
        DatumGewijzigd = CURRENT_TIMESTAMP
    WHERE Id = p_VoertuigId;

    IF EXISTS (SELECT 1 FROM voertuig_instructeur WHERE VoertuigId = p_VoertuigId) THEN
        UPDATE voertuig_instructeur
        SET InstructeurId = p_InstructeurId,
            IsActief = 1,
            DatumGewijzigd = CURRENT_TIMESTAMP
        WHERE VoertuigId = p_VoertuigId;
    ELSE
        INSERT INTO voertuig_instructeur (VoertuigId, InstructeurId, DatumToekenning, IsActief)
        VALUES (p_VoertuigId, p_InstructeurId, CURRENT_DATE, 1);
    END IF;
END
SQL);

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_verwijder_voertuig_bij_instructeur;
CREATE PROCEDURE sp_verwijder_voertuig_bij_instructeur(
    IN p_InstructeurId BIGINT UNSIGNED,
    IN p_VoertuigId BIGINT UNSIGNED
)
BEGIN
    DELETE FROM voertuig_instructeur
    WHERE InstructeurId = p_InstructeurId
      AND VoertuigId = p_VoertuigId;

    SELECT ROW_COUNT() AS Verwijderd;
END
SQL);

        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_verwijder_voertuig_uit_alle_voertuigen;
CREATE PROCEDURE sp_verwijder_voertuig_uit_alle_voertuigen(IN p_VoertuigId BIGINT UNSIGNED)
BEGIN
    IF EXISTS (
        SELECT 1
        FROM voertuig_instructeur
        WHERE VoertuigId = p_VoertuigId
          AND IsActief = 1
    ) THEN
        DELETE FROM voertuig_instructeur
        WHERE VoertuigId = p_VoertuigId;

        UPDATE voertuigen
        SET IsActief = 0,
            DatumGewijzigd = CURRENT_TIMESTAMP
        WHERE Id = p_VoertuigId;

        SELECT 1 AS IsVerwijderd, 'Het door u geselecteerde voertuig is verwijderd' AS Melding;
    ELSE
        SELECT 0 AS IsVerwijderd, 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd' AS Melding;
    END IF;
END
SQL);
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_verwijder_voertuig_uit_alle_voertuigen');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_verwijder_voertuig_bij_instructeur');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_update_voertuig');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_voertuig_edit');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_alle_voertuigen');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_beschikbare_voertuigen');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_voertuigen_bij_instructeur');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_instructeurs_in_dienst');
    }
};
