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

        cy.get("[data-id=btn-read]").click();
        cy.get("[data-id=title]").contains("Employee / ");
        cy.get("[data-id=subtitle]").contains("Detail Employee");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Employee ID");
        cy.get("[data-id=tbl-show-employee]").contains("th", "User ID");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Role");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Email");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Name");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Date of Birth");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Address");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Phone");
        cy.get("[data-id=tbl-show-employee]").contains("th", "Gender");
        cy.get("[data-id=btn-back]").contains("Back");

    });
});