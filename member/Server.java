package member;
import java.io.*;
import java.net.*;
import java.sql.*;

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
    private static int memberDeposit = 0;
    private static int total_deposits = 0; 
    private static  int loanamount = 0;
    private static int total_loanrequested = 0;
    private static int member_ID;
    private static int accountBalance;
    private static int count = 0;
    private static ResultSet resultSet1;
    private static ResultSet resultSet2;
    private static ResultSet resultSet3;
    private static ResultSet resultSet4;
    private static ResultSet resultSet5;
    private static ResultSet resultSet6;
    private static ResultSet resultSet7;
    private static Socket clientSocket;
    private static ServerSocket serverSocket;

    /* login --edwin */
    public static boolean login(String username, String password) {
        try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
                Statement statement = connection.createStatement()) {
            String query = "SELECT * FROM member WHERE username='" + username + "' AND password='" + password + "'";
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
            String query = "SELECT * FROM member WHERE member_number='" + memberNumber + "' AND phone_number='"
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
        String query = "SELECT * FROM deposit WHERE member_number = " + member_id + " AND receipt_number = " + receiptno
                + " AND date = '" + date_Deposited + "' AND amount = " + amount + "";

        try (Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
                Statement statement = connection.createStatement()) {
            ResultSet deposit = statement.executeQuery(query);
            if (deposit.next()) {
                if (deposit.getString("status").equals("pending")) {
                    Double new_balance = balance + amount;
                    String updatequery = "UPDATE member SET account_balance = " + new_balance
                            + " WHERE member_number = " + member_id + "";
                    statement.executeUpdate(updatequery);
                    /* update the status of the receipt to deposited */
                    out.println("You have deposited UGX. " + amount + " You new balance is UGX. " + new_balance);
                    String updateStatus = "UPDATE deposit SET status = 'deposited' WHERE member_number = " + member_id
                            + "";
                    statement.executeUpdate(updateStatus);
                } else {
                    out.println("Receipt is already deposited.");
                }
            } else {
                out.println("Receipt doesn't exist");
            }
        } catch (SQLException e) {
            e.printStackTrace();
            out.println("Connection failed");
        }
    }
    /* checkStatement --pius */
    public static void checkstatement(int userId, String datefrom, String dateto, PrintWriter out) {
        try {
            Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            String depositquery = "SELECT * FROM deposits WHERE depositDate BETWEEN '" + datefrom + "' AND '" + dateto + "' AND member_ID = " + userId;
            String loanquery = "SELECT * FROM loan WHERE loandepositdate BETWEEN '" + datefrom + "' AND '" + dateto + "' AND member_ID = " + userId +"";
            String percentagequery = "SELECT member_ID, COUNT(*) AS depositsTimes, SUM(amount) AS totalAmountDeposited " + "FROM deposits " + "GROUP BY member_ID ";
            String loanpercentagequery = "SELECT member_ID, COUNT(*) AS loandepositTimes, SUM(amountdeposited) AS loanamountdeposited " + 
           "FROM loan " +
           "GROUP BY member_ID";

           Statement statement = connection.createStatement();
           ResultSet depositcontribution = statement.executeQuery(depositquery);
            while (depositcontribution.next()) {
                String depositDate = depositcontribution.getString("depositDate");
                int amount = depositcontribution.getInt("amount");
                int totalAmount = 0;
                totalAmount = 0 + amount;
                out.println("Deposit Date: " + depositDate +"\n");
                out.println("Amount: " + amount + "\n");
                out.println("contribution is: " + totalAmount + "\n");
            }

            ResultSet loancontribution = statement.executeQuery(loanquery);

            while(loancontribution.next()) {
                String loandepositDate = loancontribution.getString("loandepositdate");
                int amountdeposited = loancontribution.getInt("amountdeposited");
                out.println("loan Datedeposit: " + loandepositDate + "\n");
                out.println("amountdeposited: " + amountdeposited + "\n");
            }

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
           ResultSet loanPercentageResult = statement.executeQuery(loanpercentagequery);
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
            }
           depositcontribution.close();
           loancontribution.close();
           percentageResult.close();
           loanPercentageResult.close();
           statement.close();
        } catch (Exception e) {
            e.printStackTrace();
            
        }
    }
   
    /* loan request -- allan */
    public static int requestLoan(int memberID, int amount, int repayment_period) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            statement = connection.createStatement();
            
             /* generate a random application_no value-- */
            Random random = new Random();
            application_no = 1000 + random.nextInt(9999);

             /* sql to handle loan request-- */
            String sql = "INSERT INTO loan_application(application_no,member_ID, amount, repayment_period) VALUES("
                    + application_no + "," + memberID + "," + amount + "," + repayment_period + ")";
            statement.executeUpdate(sql);
                                   
            resultSet1 = statement
                    .executeQuery("SELECT COUNT(application_no) FROM loan_application WHERE status='pending'");
            int no_of_available_requests = 0;
        
            if (resultSet1.next()) {
                no_of_available_requests = resultSet1.getInt("COUNT(application_no)");
            }
            if (no_of_available_requests == 10) {
                String changeStatus = "UPDATE loan_application SET status = 'processing' WHERE status = 'pending'";
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
                    "SELECT SUM(account_balance),SUM(loan_balance),SUM(account_balance) - SUM(loan_balance) AS difference FROM member");
            int available_funds = 0;


            if (resultSet2.next()) {
                available_funds = resultSet2.getInt("difference");
            }
            if (available_funds > 2000000) {
                resultSet3 = statement
                        .executeQuery("SELECT * FROM loan_application WHERE status = 'processing'");
                List<Integer> loanRequests = new ArrayList<>();
                List<Integer> memberIDs = new ArrayList<>();
                List<Integer> memberIndices = new ArrayList<>();  
                Map<Integer, Integer> memberDeposits = new HashMap<>();           
                List<Integer> repaymentPeriods = new ArrayList<>();
                List<Double> finalLoanAmounts = new ArrayList<>();
                List<Integer> applicationNos = new ArrayList<>();
               
               
                
                
                while (resultSet3.next()) {
                    loanamount = resultSet3.getInt("amount");
                    int memberId = resultSet3.getInt("member_ID");
                    int repaymentPeriod = resultSet3.getInt("repayment_period");
                    applicationNo = resultSet3.getInt("application_no");

                    memberIDs.add(memberId);
                    repaymentPeriods.add(repaymentPeriod);
                    applicationNos.add(applicationNo);
                    loanRequests.add(loanamount);
                    total_loanrequested += loanamount;
                    memberIndices.add(memberIDs.size() - 1);
                }   
                           
                 resultSet4 = statement.executeQuery("SELECT member_ID,account_balance FROM member WHERE member_ID IN (SELECT member_ID FROM loan_application WHERE status = 'processing')");
                                         
  
                        while (resultSet4.next()) {
                            

                            member_ID = resultSet4.getInt("member_ID");
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
                            
                               String updateLoanQuery = "UPDATE loan_application SET amount_granted="+finalLoanAmount+"WHERE application_no="+applicationNo;
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
     public static void checkLoanStatus(PrintWriter out, int applicationNumber) {
        try {
            Connection connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
            statement = connection.createStatement();
            ResultSet loan_status = statement.executeQuery("SELECT status FROM loan_application WHERE application_number =      "+applicationNumber+"");
            if (loan_status.next()) {
                String status = loan_status.getString("status");
                if (status.equals("approved")) {
                    System.out.println("Congratulations! Your loan application is approved.");
                    System.out.print("Do you want to accept the loan? (yes/no): ");
                    try (Scanner Scanner = new Scanner(System.in)) {
                        String response = Scanner.nextLine();
                        if (response.equalsIgnoreCase("yes")) {
                            // Perform the action to accept the loan
                            System.out.println(
                                    "You have accepted the loan. The amount will be transferred to your account.");
                        } else if (response.equalsIgnoreCase("no")) {
                            // Perform the action to accept the loan
                            System.out.println("You have rejected the loan.");
                        } else {
                            // Perform the action to reject the loan
                            System.out.println("you have entered an invalid input, please try again.");
                        }
                    }
                } else if (status.equals("pending")) {
                    out.println("Your loan application is still pending. Please wait for further updates.");
                } else if (status.equals("processing")) {
                    out.println("Your loan application is being processed.");
                } else {
                    out.println("Your loan application is rejected.");
                }
            } else {
                System.out.println("Loan application not found. Please check your application number.");
            }
            connection.close();
        } catch (Exception e) {
            out.println("MySQL JDBC Driver not found or other database error occurred.");
            e.printStackTrace();
        }
    }


    public static void main(String[] args) {
        try {
            serverSocket = new ServerSocket(1234);
            System.out.println("Server is running. Waiting for a client to connect...");

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
                                    String query = "SELECT * FROM member WHERE username='" + command[1]
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
                                        String query = "SELECT * FROM member WHERE member_number='" + command[1]
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
                                    out.println("No records found. Return after a day");
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
                                checkLoanStatus(out, application_number);
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
