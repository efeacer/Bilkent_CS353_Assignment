/**
 * A program that connects to a MySQL server through JDBC, creates small tables,
 * performs insertions and displays the resulting table contents.
 * @author Efe Acer
 * @version 1.0
 */

// Necessary import(s)
import java.sql.*;

public class HomeworkEA {

    // Constants
    private static final String DB_USERNAME = "efe.acer";
    private static final String DB_NAME = "efe_acer";
    private static final String DB_PASSWORD = "OJAkvncH";
    private static final String DB_URL = "jdbc:mysql://efe.acer@dijkstra.ug.bcc.bilkent.edu.tr/" +
            DB_NAME + "?user=" + DB_USERNAME + "&password=" + DB_PASSWORD;

    public static void main(String[] args) {

        try (Connection conn = DriverManager.getConnection(DB_URL);
             Statement stmt = conn.createStatement()) {

            // Drop the tables if they already exist
            // (owns should be dropped first to ensure no error occurs due to foreign key constraints)
            stmt.executeUpdate("DROP TABLE IF EXISTS owns;");
            stmt.executeUpdate("DROP TABLE IF EXISTS customer;");
            stmt.executeUpdate("DROP TABLE IF EXISTS account;");

            // Create the tables
            stmt.executeUpdate(
                    "CREATE TABLE customer(" +
                            "cid            CHAR(12) PRIMARY KEY," +
                            "name           VARCHAR(50)," +
                            "bdate          DATE," +
                            "address        VARCHAR(50)," +
                            "city           VARCHAR(20)," +
                            "nationality    VARCHAR(20)" +
                            ");"
            );
            stmt.executeUpdate(
                    "CREATE TABLE account(" +
                            "aid        CHAR(8) PRIMARY KEY," +
                            "branch     VARCHAR(20)," +
                            "balance    FLOAT," +
                            "openDate   DATE" +
                            ");"
            );
            stmt.executeUpdate(
                    "CREATE TABLE owns(" +
                            "cid    CHAR(12)," +
                            "aid    CHAR(8)," +
                            "PRIMARY KEY (cid, aid)," +
                            "FOREIGN KEY (cid) REFERENCES customer(cid) ON DELETE CASCADE," +
                            "FOREIGN KEY (aid) REFERENCES account(aid) ON DELETE CASCADE" +
                            ") ENGINE=InnoDB;"
            );

            // Insert values
            stmt.executeUpdate(
                    "INSERT INTO customer VALUES ('20000001', 'Cem', '1980-10-10', 'Tunali', 'Ankara', 'TC');"
            );
            stmt.executeUpdate(
                    "INSERT INTO customer VALUES ('20000002', 'Asli', '1985-09-08', 'Nisantasi', 'Istanbul', 'TC');"
            );
            stmt.executeUpdate(
                    "INSERT INTO customer VALUES ('20000003', 'Ahmet', '1995-02-11', 'Karsiyaka', 'Izmir', 'TC');"
            );
            stmt.executeUpdate(
                    "INSERT INTO customer VALUES ('20000004', 'John', '1990-04-16', 'Kizilay', 'Ankara', 'ABD');"
            );
            stmt.executeUpdate("INSERT INTO account VALUES ('A0000001', 'Kizilay', 2000.00, '2009-01-01');");
            stmt.executeUpdate("INSERT INTO account VALUES ('A0000002', 'Bilkent', 8000.00, '2011-01-01');");
            stmt.executeUpdate("INSERT INTO account VALUES ('A0000003', 'Cankaya', 4000.00, '2012-01-01');");
            stmt.executeUpdate("INSERT INTO account VALUES ('A0000004', 'Sincan', 1000.00, '2012-01-01');");
            stmt.executeUpdate("INSERT INTO account VALUES ('A0000005', 'Tandogan', 3000.00, '2013-01-01');");
            stmt.executeUpdate("INSERT INTO account VALUES ('A0000006', 'Eryaman', 5000.00, '2015-01-01');");
            stmt.executeUpdate("INSERT INTO account VALUES ('A0000007', 'Umitkoy', 6000.00, '2017-01-01');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000001', 'A0000001');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000001', 'A0000002');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000001', 'A0000003');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000001', 'A0000004');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000002', 'A0000002');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000002', 'A0000003');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000002', 'A0000005');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000003', 'A0000006');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000003', 'A0000007');");
            stmt.executeUpdate("INSERT INTO owns VALUES ('20000004', 'A0000006');");

            // Print table contents
            ResultSet rs = stmt.executeQuery("SELECT * FROM customer;");
            try {
                displayTable(rs);
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
            rs = stmt.executeQuery("SELECT * FROM account;");
            try {
                displayTable(rs);
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
            rs = stmt.executeQuery("SELECT * FROM owns;");
            try {
                displayTable(rs);
            } catch (SQLException ex) {
                ex.printStackTrace();
            }

        } catch (SQLException ex){ // handle the exception
            ex.printStackTrace();
        }
    }

    /**
     * Given a JDBC ResultSet object containing the resulting
     * table of a query, displays the table contents.
     * @param rs ResultSet object containing the table to print
     * @throws SQLException SQLException object that may be
     *                      thrown due to JDBC method calls
     */
    private static void displayTable(ResultSet rs) throws SQLException {
        ResultSetMetaData md = rs.getMetaData();
        System.out.println("Table: " + md.getTableName(1));
        int colNum = md.getColumnCount();
        for (int i = 1; i <= colNum; i++) { // print the attribute names
            System.out.printf("%-15s", md.getColumnLabel(i));
        }
        System.out.println();
        while (rs.next()) {
            for (int i = 1; i <= colNum; i++) { // print the rows
                System.out.printf("%-15s", rs.getString(i));
            }
            System.out.println(); // next column
        }
        System.out.println();
    }
}
