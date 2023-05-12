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

        cy.get("[data-id=btn-del]").click();
        cy.get("[data-id=success-message]").contains(
            "Employee Deleted Successfully"
        );
    });
});

