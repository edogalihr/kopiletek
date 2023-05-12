describe("auth spec", () => {

    it("admin can add employee", () => {
        cy.visit("/login");

        cy.get("[data-id=field-email]").type("admin@mail.com");
        cy.get("[data-id=field-pwd]").type("12345678");
        cy.get("[data-id=btn-signin]").click();

        cy.get("[data-id=tbl-employee]").contains("th", "Employee Id");
        cy.get("[data-id=tbl-employee]").contains("th", "User Id");
        cy.get("[data-id=tbl-employee]").contains("th", "Role");
        cy.get("[data-id=tbl-employee]").contains("th", "Name");
        cy.get("[data-id=tbl-employee]").contains("th", "Action");

        cy.get("[data-id=btn-update]").click();
        cy.get("[data-id=field-name]").click({force:true}).clear().type("Atmayanti Testing Update");
        cy.get("[data-id=field-email]").click({force:true}).clear().type("mayaUp@mail.com");
        cy.get("[data-id=field-role]").select("Kasir", {force:true});
        cy.get("[data-id=field-birth-date]").click({force:true}).clear().type("2002-12-12");
        cy.get("[data-id=field-address]").click({force:true}).clear().type("Tulungagung");
        cy.get("[data-id=field-phone]").click({force:true}).clear().type("083114514125");
        cy.get("[data-id=field-gender]").select("Female");
        cy.get("[data-id=btn-submit]").click();

        cy.get("[data-id=success-message]").contains(
            "Employee Updated Successfully"
        );
    });
});