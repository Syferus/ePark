namespace ePark.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class InitialCreate : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Spaces",
                c => new
                    {
                        SpaceID = c.Int(nullable: false, identity: true),
                        x1Coordinate = c.Double(nullable: false),
                        x2Coordinate = c.Double(nullable: false),
                        x3Coordinate = c.Double(nullable: false),
                        x4Coordinate = c.Double(nullable: false),
                        y1Coordinate = c.Double(nullable: false),
                        y2Coordinate = c.Double(nullable: false),
                        y3Coordinate = c.Double(nullable: false),
                        y4Coordinate = c.Double(nullable: false),
                        CarPark_CarParkID = c.Int(),
                    })
                .PrimaryKey(t => t.SpaceID)
                .ForeignKey("dbo.CarParks", t => t.CarPark_CarParkID)
                .Index(t => t.CarPark_CarParkID);
            
            CreateTable(
                "dbo.CarParks",
                c => new
                    {
                        CarParkID = c.Int(nullable: false, identity: true),
                        LocationID = c.Int(nullable: false),
                    })
                .PrimaryKey(t => t.CarParkID);
            
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.Spaces", "CarPark_CarParkID", "dbo.CarParks");
            DropIndex("dbo.Spaces", new[] { "CarPark_CarParkID" });
            DropTable("dbo.CarParks");
            DropTable("dbo.Spaces");
        }
    }
}
