<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125211732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE mochi.usuario_id_seq1 CASCADE');
        $this->addSql('DROP SEQUENCE mochi.video_id_seq1 CASCADE');
        $this->addSql('DROP SEQUENCE mochi.suscripcion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mochi.tipo_notificacion_id_seq1 CASCADE');
        $this->addSql('DROP SEQUENCE mochi.notificacion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mochi.mensaje_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mochi.preguntas_seguridad_id_seq1 CASCADE');
        $this->addSql('ALTER TABLE mochi.mensaje DROP CONSTRAINT id_emisor');
        $this->addSql('ALTER TABLE mochi.mensaje DROP CONSTRAINT id_receptor');
        $this->addSql('ALTER TABLE mochi.notificacion DROP CONSTRAINT tipo_notificacion_notificacion');
        $this->addSql('ALTER TABLE mochi.suscripcion DROP CONSTRAINT suscriptor_suscripcion');
        $this->addSql('ALTER TABLE mochi.suscripcion DROP CONSTRAINT canal_suscripcion');
        $this->addSql('DROP TABLE mochi.mensaje');
        $this->addSql('DROP TABLE mochi.notificacion');
        $this->addSql('DROP TABLE mochi.suscripcion');
        $this->addSql('ALTER TABLE mochi.comentario ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.comentario ALTER id_usuario SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER id_video SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER fav DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.comentario ALTER fav SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER dislike DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.comentario ALTER dislike SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER comentario SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER comentario TYPE VARCHAR(500)');
        $this->addSql('ALTER TABLE mochi.preguntas_seguridad ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.preguntas_seguridad ALTER pregunta SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_seguridad ALTER pregunta TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER id_usuario SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER id_pregunta SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER respuesta SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER respuesta TYPE VARCHAR(255)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6382389BFCF8192D ON mochi.preguntas_usuario (id_usuario)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6382389BFE3B0D62 ON mochi.preguntas_usuario (id_pregunta)');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES mochi.usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER id_comentario SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER mensaje SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER mensaje TYPE VARCHAR(500)');
        $this->addSql('ALTER TABLE mochi.tematica ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.tematica ALTER tematica SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.tematica ALTER tematica TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.tipo_notificacion ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.tipo_notificacion ALTER tipo SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.tipo_notificacion ALTER tipo TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.usuario ALTER nombre TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER apellidos TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER username TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER nombre_canal TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER descripcion SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.usuario ALTER descripcion TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER suscriptores DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.usuario ALTER suscriptores SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.usuario ALTER imagen TYPE VARCHAR(500)');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER id_video SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER id_usuario SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER fav DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER fav SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER dislike DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER dislike SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mochi.video ALTER id_canal SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER id_tematica SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER titulo TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.video ALTER descripcion SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER descripcion TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE mochi.video ALTER url SET NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER url TYPE VARCHAR(500)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA nise');
        $this->addSql('CREATE SEQUENCE mochi.usuario_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mochi.video_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mochi.suscripcion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mochi.tipo_notificacion_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mochi.notificacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mochi.mensaje_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mochi.preguntas_seguridad_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mochi.mensaje (id SERIAL NOT NULL, id_emisor INT DEFAULT NULL, id_receptor INT DEFAULT NULL, mensaje VARCHAR(500) DEFAULT NULL, fecha DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D583E82E29930A3 ON mochi.mensaje (id_emisor)');
        $this->addSql('CREATE INDEX IDX_D583E82B91944F2 ON mochi.mensaje (id_receptor)');
        $this->addSql('CREATE TABLE mochi.notificacion (id SERIAL NOT NULL, id_tipo INT DEFAULT NULL, id_usuario INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_397EF493FB0D0145 ON mochi.notificacion (id_tipo)');
        $this->addSql('CREATE TABLE mochi.suscripcion (id SERIAL NOT NULL, id_suscriptor INT DEFAULT NULL, id_canal INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E0704785CFAA2E35 ON mochi.suscripcion (id_suscriptor)');
        $this->addSql('CREATE INDEX IDX_E0704785F04BA69 ON mochi.suscripcion (id_canal)');
        $this->addSql('ALTER TABLE mochi.mensaje ADD CONSTRAINT id_emisor FOREIGN KEY (id_emisor) REFERENCES mochi.usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mochi.mensaje ADD CONSTRAINT id_receptor FOREIGN KEY (id_receptor) REFERENCES mochi.usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mochi.notificacion ADD CONSTRAINT tipo_notificacion_notificacion FOREIGN KEY (id_tipo) REFERENCES mochi.tipo_notificacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mochi.suscripcion ADD CONSTRAINT suscriptor_suscripcion FOREIGN KEY (id_suscriptor) REFERENCES mochi.usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mochi.suscripcion ADD CONSTRAINT canal_suscripcion FOREIGN KEY (id_canal) REFERENCES mochi.usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE SEQUENCE mochi.comentario_id_seq');
        $this->addSql('SELECT setval(\'mochi.comentario_id_seq\', (SELECT MAX(id) FROM mochi.comentario))');
        $this->addSql('ALTER TABLE mochi.comentario ALTER id SET DEFAULT nextval(\'mochi.comentario_id_seq\')');
        $this->addSql('ALTER TABLE mochi.comentario ALTER id_usuario DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER id_video DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER fav SET DEFAULT false');
        $this->addSql('ALTER TABLE mochi.comentario ALTER fav DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER dislike SET DEFAULT false');
        $this->addSql('ALTER TABLE mochi.comentario ALTER dislike DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER comentario DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.comentario ALTER comentario TYPE VARCHAR(100)');
        $this->addSql('CREATE SEQUENCE mochi.tematica_id_seq');
        $this->addSql('SELECT setval(\'mochi.tematica_id_seq\', (SELECT MAX(id) FROM mochi.tematica))');
        $this->addSql('ALTER TABLE mochi.tematica ALTER id SET DEFAULT nextval(\'mochi.tematica_id_seq\')');
        $this->addSql('ALTER TABLE mochi.tematica ALTER tematica DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.tematica ALTER tematica TYPE VARCHAR(250)');
        $this->addSql('CREATE SEQUENCE mochi.preguntas_seguridad_id_seq');
        $this->addSql('SELECT setval(\'mochi.preguntas_seguridad_id_seq\', (SELECT MAX(id) FROM mochi.preguntas_seguridad))');
        $this->addSql('ALTER TABLE mochi.preguntas_seguridad ALTER id SET DEFAULT nextval(\'mochi.preguntas_seguridad_id_seq\')');
        $this->addSql('ALTER TABLE mochi.preguntas_seguridad ALTER pregunta DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_seguridad ALTER pregunta TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('CREATE SEQUENCE mochi.usuario_id_seq');
        $this->addSql('SELECT setval(\'mochi.usuario_id_seq\', (SELECT MAX(id) FROM mochi.usuario))');
        $this->addSql('ALTER TABLE mochi.usuario ALTER id SET DEFAULT nextval(\'mochi.usuario_id_seq\')');
        $this->addSql('ALTER TABLE mochi.usuario ALTER nombre TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER apellidos TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER username TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER email TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER nombre_canal TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER descripcion DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.usuario ALTER descripcion TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE mochi.usuario ALTER suscriptores SET DEFAULT 0');
        $this->addSql('ALTER TABLE mochi.usuario ALTER suscriptores DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.usuario ALTER imagen TYPE VARCHAR(200)');
        $this->addSql('CREATE SEQUENCE mochi.valoracion_id_seq');
        $this->addSql('SELECT setval(\'mochi.valoracion_id_seq\', (SELECT MAX(id) FROM mochi.valoracion))');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER id SET DEFAULT nextval(\'mochi.valoracion_id_seq\')');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER id_video DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER id_usuario DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER fav SET DEFAULT false');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER fav DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER dislike SET DEFAULT false');
        $this->addSql('ALTER TABLE mochi.valoracion ALTER dislike DROP NOT NULL');
        $this->addSql('DROP INDEX UNIQ_6382389BFCF8192D');
        $this->addSql('DROP INDEX UNIQ_6382389BFE3B0D62');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario DROP CONSTRAINT mochi.preguntas_usuario_pkey');
        $this->addSql('CREATE SEQUENCE mochi.preguntas_usuario_id_seq');
        $this->addSql('SELECT setval(\'mochi.preguntas_usuario_id_seq\', (SELECT MAX(id) FROM mochi.preguntas_usuario))');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER id SET DEFAULT nextval(\'mochi.preguntas_usuario_id_seq\')');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER id_usuario DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER id_pregunta DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER respuesta DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.preguntas_usuario ALTER respuesta TYPE VARCHAR(250)');
        $this->addSql('CREATE INDEX IDX_6382389BFCF8192D ON mochi.preguntas_usuario (id_usuario)');
        $this->addSql('CREATE INDEX IDX_6382389BFE3B0D62 ON mochi.preguntas_usuario (id_pregunta)');
        $this->addSql('CREATE SEQUENCE mochi.video_id_seq');
        $this->addSql('SELECT setval(\'mochi.video_id_seq\', (SELECT MAX(id) FROM mochi.video))');
        $this->addSql('ALTER TABLE mochi.video ALTER id SET DEFAULT nextval(\'mochi.video_id_seq\')');
        $this->addSql('ALTER TABLE mochi.video ALTER id_canal DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER id_tematica DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER titulo TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE mochi.video ALTER descripcion DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER descripcion TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE mochi.video ALTER url DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.video ALTER url TYPE VARCHAR(200)');
        $this->addSql('CREATE SEQUENCE mochi.respuesta_id_seq');
        $this->addSql('SELECT setval(\'mochi.respuesta_id_seq\', (SELECT MAX(id) FROM mochi.respuesta))');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER id SET DEFAULT nextval(\'mochi.respuesta_id_seq\')');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER id_comentario DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER mensaje DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.respuesta ALTER mensaje TYPE VARCHAR(100)');
        $this->addSql('CREATE SEQUENCE mochi.tipo_notificacion_id_seq');
        $this->addSql('SELECT setval(\'mochi.tipo_notificacion_id_seq\', (SELECT MAX(id) FROM mochi.tipo_notificacion))');
        $this->addSql('ALTER TABLE mochi.tipo_notificacion ALTER id SET DEFAULT nextval(\'mochi.tipo_notificacion_id_seq\')');
        $this->addSql('ALTER TABLE mochi.tipo_notificacion ALTER tipo DROP NOT NULL');
        $this->addSql('ALTER TABLE mochi.tipo_notificacion ALTER tipo TYPE VARCHAR(50)');
    }
}
