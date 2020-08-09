DROP TABLE IF EXISTS "TestEntity";

CREATE TABLE "TestEntity" (
    "userId" SERIAL  NOT NULL,
    "firstName" VARCHAR(250)  DEFAULT NULL,
    "relativeExtendedId" BIGINT  DEFAULT NULL,
    "birthDate" DATE  DEFAULT NULL,
    "createdAt" TIMESTAMP  DEFAULT NULL,
    "intType" BIGINT  DEFAULT NULL,
    "floatType" NUMERIC(5,2)  DEFAULT NULL,
    "doubleType" NUMERIC  DEFAULT NULL,
    "booleanType" BOOLEAN  DEFAULT NULL,
    "extraProperty" text,
    CONSTRAINT pk_TestEntity_userId PRIMARY KEY ("userId")
);

DROP TABLE IF EXISTS "TestRelativeEntity";

CREATE TABLE "TestRelativeEntity" (
    "relativeId" SERIAL  NOT NULL,
    "userId" BIGINT  DEFAULT NULL,
    "relativeName" VARCHAR(250)  DEFAULT NULL,
    "extraProperty" text,
    CONSTRAINT pk_TestRelativeEntity_relativeId PRIMARY KEY ("relativeId")
);

DROP TABLE IF EXISTS "TestRelativeExtendedEntity";
CREATE TABLE "TestRelativeExtendedEntity" (
    "relativeExtendedId" SERIAL  NOT NULL,
    "name" VARCHAR(50)  DEFAULT NULL,
    "extraProperty" text,
    CONSTRAINT pk_TestRelativeExtendedEntity_relativeExtendedId PRIMARY KEY ("relativeExtendedId")
);