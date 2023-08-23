package member;

import java.io.*;
import java.net.*;
import java.sql.*;
import java.util.*;
import java.text.DecimalFormat;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;

public class Server {
    /* database variables */
     public static final String DB_URL = "jdbc:mysql://localhost:3306/uprise-sacco";
    public static final String DB_USER = "root";
    public static final String DB_PASSWORD = "";
    private static Connection connection;
    private static Statement statement;
    private static int application_no;
    private static int applicationNo;
    private static int application_number_app;
    private static int member_id_app;
    private static int amount_app;
    private static int repayment_period_app;
    private static int requestedAmount = 0;
    private static int amount_granted = 0;
    private static double repaymentPeriod = 0;
    private static double monthlyPayment = 0;
    private static int memberDeposit = 0;
    private static int total_deposits = 0; 
    private static  int loanamount = 0;
    private static int application_number = 0;
    private static int total_loanrequested = 0;
    private static int member_ID;
    private static int memberID;
    private static int accountBalance;
    private static int count = 0;
    private static ResultSet loan_status =null;
    private static ResultSet resultSet1;
    private static ResultSet resultSet2;
    private static ResultSet resultSet3;
    private static ResultSet resultSet4;
    private static ResultSet resultSet5 =null;
    private static ResultSet resultSet6;
    private static ServerSocket serverSocket;
    private static BufferedReader in;
    private static PrintWriter out;


    /* login --edwin */
    public static boolean login(String username, String password) {
        try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
                Statement statement = connection.createStatement()) {
            String query = "SELECT * FROM members WHERE username='" + username + "' AND password='" + password + "'";
            ResultSet resultSet = statement.executeQuery(query);
            return resultSet.next();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    public static boolean recoverPassword(String memberNumber, String phoneNumber) {
        try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
                Statement statement = connection.createStatement()) {
            String query = "SELECT * FROM members WHERE member_number='" + memberNumber + "' AND phone_number='"
                    + phoneNumber + "'";
            ResultSet resultSet = statement.executeQuery(query);
            return resultSet.next();
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }
    /* login ends here */

    /* deposit method --Vanessa */
    public static void performDeposit(PrintWriter out, Double amount, String date_Deposited, int receiptno,
            int member_id, Double balance) {
        /* check if the receipt exists */
        String query = "SELECT * FROM deposits WHERE member_number = " + member_id + " AND receipt_number = " + receiptno + " AND date = '" + date_Deposited + "' AND amount = " + amount + "";
        try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
                Statement statement = connection.createStatement()) {
            ResultSet deposit = statement.executeQuery(query);
            if (deposit.next()) {
                if (deposit.getString("status").equals("pending")) {
                    Double new_balance = balance + amount;
                    String updatequery = "UPDATE members SET account_balance = " + new_balance
                            + " WHERE member_number = " + member_id + "";
                    statement.executeUpdate(updatequery);
                    /* update the status of the receipt to deposited */
                    out.println("You have deposited UGX. " + amount + " You new balance is UGX. " + new_balance);
                    String updateStatus = "UPDATE deposits SET status = 'deposited' WHERE member_number = " + member_id
                            + "";
                    statement.executeUpdate(updateStatus);
                } else {
                    out.println("Receipt is already deposited.");
                }
            } else {
                Random random = new Random();
                int referenceNumber = random.nextInt(10000);
                String category = "deposit";
                String status = "pending";
                String requestQuery = "INSERT INTO notifications(reference_number, category, receipt_number, member_number, status) " +
                "VALUES(" + referenceNumber + ",'" + category + "'," + receiptno + "," + member_id + ",'" + status + "')";
;
            statement.executeUpdate(requestQuery);
                out.println("Receipt doesn't exist. Try again after 24 hours. Reference Number is: "+referenceNumber+" for follow up");
            }
        } catch (SQLException e) {
            e.printStackTrace();
            out.println("Connection failed");
        }
    }
    /* checkStatement --pius */
    public static void checkstatement(int userId, String datefrom, String dateto, PrintWriter out) {
        StringBuilder checkstatement = new StringBuilder("Deposits");
        try {
            Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            String deposit_query = "SELECT * FROM deposits WHERE date BETWEEN '" + datefrom + "' AND '" + dateto + "' AND member_number = " + userId;
            String loan_repayment_query = "SELECT * FROM loan_repayments WHERE date BETWEEN '" + datefrom + "' AND '" + dateto + "' AND member_number = " + userId +"";
            /* String loan_progress_query = "SELECT * FROM loan WHERE member_number = "+userId+"";*/
            /* 
            String percentagequery = "SELECT member_number, COUNT(*) AS depositsTimes, SUM(amount) AS totalAmountDeposited " + "FROM deposit " + "GROUP BY member_number ";
            String loanpercentagequery = "SELECT member_number, COUNT(*) AS loandepositTimes, SUM(amount) AS loanamountdeposited " + 
           "FROM loan " +
           "GROUP BY member_number";
           */
            Statement statement = connection.createStatement();
            ResultSet depositcontribution = statement.executeQuery(deposit_query);
            while (depositcontribution.next()) {
                String depositDate = depositcontribution.getString("date");
                double amount = depositcontribution.getDouble("amount");
                checkstatement.append("Deposits\nDate: "+depositDate+"\nAmount: "+amount);
            }
            ResultSet loancontribution = statement.executeQuery(loan_repayment_query);
            while(loancontribution.next()) {
                String loandepositDate = loancontribution.getString("date");
                double amountdeposited = loancontribution.getDouble("amount");
                checkstatement.append("\nLoan repayments\nDate: "+loandepositDate+"\nAmount: "+amountdeposited);
            }
            out.println(checkstatement.toString());
            /* 
            ResultSet percentageResult = statement.executeQuery(percentagequery);
                while(percentageResult.next()){
                int member_ID= percentageResult.getInt("member_ID");
                if(userId == member_ID){
                    int depositsTimes = percentageResult.getInt("depositsTimes");
                    int totalAmountDeposited = percentageResult.getInt("totalAmountDeposited");
                    double percentage = (double) depositsTimes / 12 * 100;
                    out.println("totalAmountDepositedonloan: " +totalAmountDeposited + "\n");
                    out.println("depositsTimes: " + depositsTimes + "\n");
                    out.println("percentage contribution: " + percentage + "\n");
                }
            }
            */
           /* ResultSet loanPercentageResult = statement.executeQuery(loanpercentagequery);
            while(loanPercentageResult.next()){
                int member_ID= loanPercentageResult.getInt ("member_ID");
                if(userId == member_ID){
                    int loandepositTimes = loanPercentageResult.getInt("loandepositTimes");
                    int loanamountdeposited = loanPercentageResult.getInt("loanamountdeposited");
                    double percentage;
                    percentage = (double)loandepositTimes / 12*100;

                    out.println("loanmountDeposited: " + loanamountdeposited + "\n");
                    out.println("percentage contribution loan: " + percentage + "\n");
              
                    System.out.println();

                }
            } */
           depositcontribution.close();
           loancontribution.close();
           /*percentageResult.close();*/
           /* loanPercentageResult.close();*/
           statement.close();
        } catch (Exception e) {
            e.printStackTrace();
            
        }
    }
    /* loan request -- allan */
       public static int requestLoan(int memberID, double amount, int repayment_period) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            statement = connection.createStatement();
            Random random = new Random();
            application_no = 1000 + random.nextInt(9999);
            String sql = "INSERT INTO loan_applications(application_number,member_number, amount, repayment_period) VALUES("
                    + application_no + "," + memberID + "," + amount + "," + repayment_period + ")";
            statement.executeUpdate(sql);
                                   
            resultSet1 = statement
                    .executeQuery("SELECT COUNT(application_number) FROM loan_applications WHERE status='pending'");
            int no_of_available_requests = 0;
        
            if (resultSet1.next()) {
                no_of_available_requests = resultSet1.getInt("COUNT(application_number)");
            }
            if (no_of_available_requests == 10) {
                String changeStatus = "UPDATE loan_applications SET status = 'processing' WHERE status = 'pending'";
                statement.executeUpdate(changeStatus);

                loandistributionandapproval();
            }
            // Close the resources
        resultSet1.close();
        statement.close();
        connection.close();      

        } catch (Exception e) {
            e.printStackTrace();
        }
        return application_no;
    }   
     
          public static void loandistributionandapproval(){ 
     try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            statement = connection.createStatement();

            resultSet2 = statement.executeQuery(
                    "SELECT SUM(account_balance),SUM(loan_balance),SUM(account_balance) - SUM(loan_balance) AS difference FROM members");
            int available_funds = 0;


            if (resultSet2.next()) {
                available_funds = resultSet2.getInt("difference");
            }
            if (available_funds > 2000000) {
                resultSet3 = statement
                        .executeQuery("SELECT * FROM loan_applications WHERE status = 'processing'");
                List<Integer> loanRequests = new ArrayList<>();
                List<Integer> memberIDs = new ArrayList<>();
                List<Integer> memberIndices = new ArrayList<>();  
                Map<Integer, Integer> memberDeposits = new HashMap<>();           
                List<Integer> repaymentPeriods = new ArrayList<>();
                List<Double> finalLoanAmounts = new ArrayList<>();
                List<Integer> applicationNos = new ArrayList<>();
                
                while (resultSet3.next()) {
                    loanamount = resultSet3.getInt("amount");
                    int memberId = resultSet3.getInt("member_number");
                    int repaymentPeriod = resultSet3.getInt("repayment_period");
                    applicationNo = resultSet3.getInt("application_number");

                    memberIDs.add(memberId);
                    repaymentPeriods.add(repaymentPeriod);
                    applicationNos.add(applicationNo);
                    loanRequests.add(loanamount);
                    total_loanrequested += loanamount;
                    memberIndices.add(memberIDs.size() - 1);
                }   
                           
                 resultSet4 = statement.executeQuery("SELECT member_number,account_balance FROM members WHERE member_number IN (SELECT member_number FROM loan_applications WHERE status = 'processing')");
                                         
  
                        while (resultSet4.next()) {
                            

                            member_ID = resultSet4.getInt("member_number");
                            accountBalance = resultSet4.getInt("account_balance");
                         
                            memberDeposits.put(member_ID, accountBalance);
                            total_deposits += accountBalance;
                            
                            }
                             // destribute loan to members based on their requested loan,their deposit
                         for (int i = 0; i < loanRequests.size(); i++) {
                             requestedAmount = loanRequests.get(i);
                             member_ID = memberIDs.get(i);
                             int memberIndex = memberIndices.get(i); 

                             if (memberIndex >= 0 && memberIndex < memberDeposits.size()) {
                                int memberDeposit = memberDeposits.get(member_ID);
                                
                                double membershare = (double) requestedAmount / total_loanrequested * available_funds;
                                double maxloanAllowed = (3.0 / 4) * memberDeposit;
                        
                                double finalLoanAmount = Math.min(requestedAmount, Math.min(membershare, maxloanAllowed));
                                finalLoanAmounts.add(finalLoanAmount);
                            } else {
                               System.out.println("Out of length");
                            }
                        
                        } 
                        for (int i = 0; i < loanRequests.size(); i++) {
                            int applicationNo = applicationNos.get(i); 
                            double finalLoanAmount = finalLoanAmounts.get(i);
                            String updateLoanQuery = "UPDATE loan_applications SET amount_granted="+finalLoanAmount+"WHERE application_number="+applicationNo;
                statement.executeUpdate(updateLoanQuery);
            }
                    
                    // Close the resources
            resultSet2.close();
            resultSet3.close();
            resultSet4.close();
                
            }
          

        } catch (Exception e) {
            e.printStackTrace();
        }finally {
            // Close the resources
            try {
                if (statement  != null) statement.close();
                if (connection != null) connection.close();
                if (resultSet2 != null) resultSet1.close();
                if (resultSet3 != null) resultSet1.close();
                if (resultSet4 != null) resultSet1.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

}
    
    

    /* loan request status -- taras */
     public static void checkLoanStatus(PrintWriter out, int applicationNumber, BufferedReader in) {
        StringBuilder loanStatus = new StringBuilder();
        DecimalFormat decimalFormat = new DecimalFormat("#.##");
       
        try {
            Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            statement = connection.createStatement();
            loan_status = statement.executeQuery("SELECT status,member_number FROM loan_applications WHERE application_number =      "+applicationNumber+"");
            if (loan_status.next()) {
                String status = loan_status.getString("status");
                int memberID = loan_status.getInt("member_number");
                if (status.equals("Approved")) {
                    resultSet5 = statement.executeQuery("SELECT amount_granted,repayment_period FROM loan_applications WHERE application_number=" +application_number);
                    while (resultSet5.next()) {
                       amount_granted = resultSet5.getInt("amount_granted");
                       int repaymentPeriod = resultSet5.getInt("repayment_period");
                       double interestRate = 0.05;
                       
                       out.println("Congragulations your loan has been approved.Do you accept the loan of:"+amount_granted+ "? (accept/reject):");                                                    
                        
                        String response = in.readLine();
                        if (response.equalsIgnoreCase("accept")) {
                            statement.executeUpdate("UPDATE members SET loan_balance = loan_balance+" +amount_granted  +" WHERE member_number ="+memberID);
                              
                       double powFactor = Math.pow(1 + interestRate, repaymentPeriod);
                       double monthlyPayment = (amount_granted * interestRate * powFactor) / (powFactor - 1);

                       List<String> installmentDates = cal_installment(repaymentPeriod);
                       
                       double truncatedMonthlyPayment = Double.parseDouble(decimalFormat.format(monthlyPayment));
                       for (int i=0; i<repaymentPeriod; i++){
                        String installmentDate = installmentDates.get(i);
                        
                        String insertQuery = "INSERT INTO loan_repayments (application_number, member_number, amount, due_date) " +
                                             "VALUES (" + applicationNumber + ", " + memberID + ", " + truncatedMonthlyPayment + ", '" + installmentDate + "')";
                        
                       statement.executeUpdate(insertQuery);
                       loanStatus.append("Installment "+(i+1)).append(" Amount: ").append(truncatedMonthlyPayment).append(" Due Date: ").append(installmentDates.get(i)).append("\n");             
                      }
                       out.println(loanStatus.toString());
                         
                          //  statement.executeUpdate("DELETE FROM loan_applications WHERE application_number = " + applicationNumber);
                        } else if (response.equalsIgnoreCase("reject")) {
                          //  statement.executeUpdate("DELETE FROM loan_applications WHERE application_number = " + applicationNumber);
                            out.println("You have rejected the loan.");
                           
                        } else {
                            
                            out.println("you have entered an invalid input, please try again.");
                        }
                   }  
                   
                } else if (status.equals("pending")) {
                    out.println("Your loan application is still pending. Please wait for further updates.");
                } else if (status.equals("processing")) {
                    out.println("Your loan application is being processed.");
                } else if (status.equals("rejected")) {
                   // statement.executeUpdate("DELETE FROM loan_applications WHERE application_number = " + applicationNumber);
                    out.println("Your loan application is rejected.");
                }
            } else {
                    out.println("Loan application not found. Please check your application number.");
            }
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
            if (resultSet5 != null) { 
                resultSet5.close();
                }
            if (loan_status != null) { 
                loan_status.close();
            }
            if (statement != null) {
                statement.close();
            }
            if (connection != null) {
                connection.close();
            }
            } catch (SQLException ex) {
               ex.printStackTrace();
            }
        }
    }
    public static List<String> cal_installment(double repaymentPeriod) {
        List<String> installmentDates = new ArrayList<>();
        LocalDate currentDate = LocalDate.now();

        for (int i=0; i<repaymentPeriod; i++){
            LocalDate dueDate = currentDate.plusMonths(i+1);
            installmentDates.add(dueDate.toString());
        }
        return installmentDates;

    }

    /*--loan-repayment---Allan */
    public static void loanRepayment(int memberID, int application_no, double amount, PrintWriter out) {
    try {
         Class.forName("com.mysql.cj.jdbc.Driver");
         connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
         statement = connection.createStatement();
            
        resultSet5 = statement.executeQuery("SELECT id, amount, due_date FROM loan_repayments WHERE member_number = " + memberID + " AND application_number = " + application_no+ " AND status = 'pending'");
        if (resultSet5.next()) {
            double repayment_amount = resultSet5.getDouble("amount");
            LocalDate repayment_date = resultSet5.getDate("due_date").toLocalDate();

            if (amount == repayment_amount && LocalDate.now().equals(repayment_date)) {
                String updateMemberQuery = "UPDATE members SET loan_balance = loan_balance - " + amount + " WHERE member_number = " + memberID;
                statement.executeUpdate(updateMemberQuery);
                out.println("Loan repayment received Successfully");

                DateTimeFormatter dateFormatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
                String formattedDate = repayment_date.format(dateFormatter);
                String updateRepaymentQuery = "UPDATE loan_repayments SET status = 'paid' WHERE member_number = " + memberID + " AND application_number = " + application_no + " AND due_date = '" + formattedDate + "'";
                statement.executeUpdate(updateRepaymentQuery);
             
            } else {
                out.println("Payment not made on the specified date or the amount being repayed does not match the amount Specified.");
            }
        } else {
                out.println("No matching loan repayment records found.");
        }

        resultSet5.close();
        statement.close();
        connection.setAutoCommit(false);
        connection.close();
    } catch (Exception e) {
        e.printStackTrace();
    }
} 

/*--loan-record----Allan */
public static void loanRecord(int memberID, PrintWriter out){
    try {
    Class.forName("com.mysql.cj.jdbc.Driver");
    connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
    statement = connection.createStatement();

    StringBuilder records = new StringBuilder();
    resultSet6 = statement.executeQuery("SELECT application_number,member_number,amount,due_date,status FROM loan_repayments WHERE member_number = " +memberID); 
    while(resultSet6.next()){
        int applicationNo = resultSet6.getInt("application_number");
        double amount  = resultSet6.getDouble("amount");
        LocalDate date = resultSet6.getDate("due_date").toLocalDate();
        String status = resultSet6.getString("status");
        records.append("Application number:").append(applicationNo).append(" Amount: ").append(amount).append(" Date: ").append(date).append(" status: ").append(status).append("\n");
       
    } 
    out.println(records.toString());   

    } catch (Exception e) {
        e.printStackTrace();
    }
}
       
    public static void main(String[] args) {
        try {
            serverSocket = new ServerSocket(1234);
            System.out.println("Server is running. Waiting for a client to connect...");
            Socket clientSocket = null;
            clientSocket = serverSocket.accept();
            System.out.println("Client connected.");

            BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
            PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
            String inputLine;
            boolean isLoggedIn = false;
            int member_id = 0;
            double account_balance = 0.0;
            double loan_balance = 0.0;

            while ((inputLine = in.readLine()) != null) {
                String[] command = inputLine.split(" ");
                if (command.length > 1 && command.length < 5) {
                    switch (command[0]) {
                        case "login":
                            if (!isLoggedIn && login(command[1], command[2])) {

                                out.println("Successfully logged in");
                                isLoggedIn = true;

                                try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
                                        Statement statement = connection.createStatement()) {
                                    String query = "SELECT * FROM members WHERE username='" + command[1]
                                            + "' AND password='" + command[2] + "'";
                                    ResultSet resultSet = statement.executeQuery(query);
                                    while (resultSet.next()) {
                                        member_id = resultSet.getInt("member_number");
                                        account_balance = resultSet.getDouble("account_balance");
                                        loan_balance = resultSet.getDouble("loan_balance");
                                    }
                                } catch (SQLException e) {
                                    e.printStackTrace();
                                }

                            } else if (isLoggedIn) {
                                out.println("You are already logged in.");
                            } else {
                                out.println("login failed");
                            }
                            break;
                        case "forgotPassword":
                            if (!isLoggedIn) {
                                if (recoverPassword(command[1], command[2])) {
                                    try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER,
                                            DB_PASSWORD);
                                            Statement statement = connection.createStatement()) {
                                        String query = "SELECT * FROM members WHERE member_number='" + command[1]
                                                + "' AND phone_number='" + command[2] + "'";
                                        ResultSet resultSet = statement.executeQuery(query);
                                        while (resultSet.next()) {
                                            String password = resultSet.getString("password");
                                            out.println("Your password is: " + password
                                                    + ". Use the login command to login now.");
                                        }
                                    } catch (SQLException e) {
                                        e.printStackTrace();
                                    }

                                } else {
                                    Random random1 = new Random();
                                    int referenceNumber = random1.nextInt(10000);
                                    String category = "login";
                                    String status = "pending";
                                    try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER,
                                            DB_PASSWORD);
                                            Statement statement = connection.createStatement()) {
                                                String requestQuery = "INSERT INTO notifications(reference_number, category, member_number, status) " +
                                                "VALUES(" + referenceNumber + ",'" + category + "'," + command[1] + ",'" + status + "')";;
                                            statement.executeUpdate(requestQuery);
                                    } catch (SQLException e) {
                                        e.printStackTrace();
                                    }
                                    out.println("No records found. Return after a day. Your reference is : "+referenceNumber+" for follow up");
                                }
                            } else {
                                out.println("You are already logged in.");
                            }
                            break;

                        case "deposit":
                            if (isLoggedIn) {
                                Double amount = Double.parseDouble(command[1]);
                                int receipt = Integer.parseInt(command[3]);
                                performDeposit(out, amount, command[2], receipt, member_id, account_balance);
                                /* call the deposit method here */
                            } else {
                                out.println("You must log in first to perform this operation.");
                            }
                            break;
                        case "CheckStatement":
                            if (isLoggedIn) {
                                checkstatement(member_id, command[1], command[2],out);
                                /* call the CheckStatement method here */
                            } else {
                                out.println("You must log in first to perform this operation.");
                            }
                            break;
                        case "requestLoan":
                            if (isLoggedIn) {
                                double loan_amount = Double.parseDouble(command[1]);
                                int payment_period = Integer.parseInt(command[2]);
                                application_no = requestLoan(member_id, loan_amount, payment_period);
                                out.println("Loan request received successfully. Application number: "
                                        + application_no);
                            } else {
                                out.println("You must log in first to perform this operation.");
                            }
                            break;
                        case "LoanRequestStatus":
                            if (isLoggedIn) {
                                int application_number = Integer.parseInt(command[1]);
                                checkLoanStatus(out, application_number, in);
                            } else {
                                out.println("You must log in first to perform this operation.");
                            }
                            break;
                        case "loanRecord":  
                            if (isLoggedIn) {
                               int memberID = Integer.parseInt(command[1]);
                               loanRecord(memberID, out);
                            } else {
                                out.println("You must log in first to perform this operation.");
                            }
                            break;      
                        default:
                            out.println("Invalid command");
                    }
                } else {
                    out.println("Invalid  command");
                }
            }

            in.close();
            out.close();
            clientSocket.close();
            serverSocket.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
