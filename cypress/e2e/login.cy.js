describe("auth spec", () => {
    it("user can access login page", () => {
        cy.visit("/login");

        cy.get("[data-id=bg-img]").should("be.visible");
        cy.get("[data-id=title]").should("have.text", "Sign In");
        cy.get("[data-id=lbl-email]").should("have.text", "Email");
        cy.get("[data-id=lbl-pwd]").should("have.text", "Password");
        cy.get("[data-id=btn-signin]").contains("Sign In").and("be.enabled");
        cy.get("[data-id=txt-signup]").should(
            "have.text",
            "Not a member? Sign Up"
        );
    });

    it("user as admin can login with valid credentials", () => {
        cy.visit("/login");

        cy.get("[data-id=field-email]").type("admin@mail.com");
        cy.get("[data-id=field-pwd]").type("12345678");
        cy.get("[data-id=btn-signin]").click();

        cy.get("[data-id=tbl-employee]").contains("th", "Employee Id");
        cy.get("[data-id=tbl-employee]").contains("th", "User Id");
        cy.get("[data-id=tbl-employee]").contains("th", "Role");
        cy.get("[data-id=tbl-employee]").contains("th", "Name");
        cy.get("[data-id=tbl-employee]").contains("th", "Action");
    });

    it("user login with invalid credentials", () => {
        cy.visit("/login");

        cy.get("[data-id=field-email]").type("admin@admin.net");
        cy.get("[data-id=field-pwd]").type("12345678");
        cy.get("[data-id=btn-signin]").click();

        cy.get("[data-id=invalid-email]").contains(
            "These credentials do not match our records."
        );
    });
});