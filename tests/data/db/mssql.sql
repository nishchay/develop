DROP TABLE IF EXISTS "TestEntity";
CREATE TABLE "TestEntity" (
    "userId" BIGINT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    "firstName" VARCHAR(250) NOT NULL,
    "relativeExtendedId" BIGINT NULL,
    "birthDate" DATE NULL,
    "createdAt" DATETIME NULL,
    "intType" BIGINT NULL,
    "floatType" NUMERIC(5,2) NULL,
    "doubleType" NUMERIC(5,2) NULL,
    "booleanType" TINYINT NULL,
    "extraProperty" TEXT NULL
);

DROP TABLE IF EXISTS "TestRelativeEntity";
CREATE TABLE "TestRelativeEntity" (
    "relativeId" BIGINT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    "userId" BIGINT NULL,
    "relativeName" VARCHAR(250) NULL,
    "extraProperty" TEXT NULL
);

DROP TABLE IF EXISTS "TestRelativeExtendedEntity";
CREATE TABLE "TestRelativeExtendedEntity" (
    "relativeExtendedId" BIGINT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    "name" VARCHAR(50) NULL,
    "extraProperty" TEXT NULL
);
