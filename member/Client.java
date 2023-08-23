package member;
import java.io.*;
import java.net.*;

public class Client {
    public static String displayMenu() {
        String menu = "\n\t\tCommands\n-----------------------------------------------\n- deposit <amount> <date_deposited> <receipt_number>\n- CheckStatement <dateFrom> <dateTo>\n- requestLoan <amount> <paymentPeriod_in_months>\n- LoanRequestStatus <loan_application_number>\n- loanRepayment <application_number> <amount>\n- loanRecord <member_ID>\n- exit\n";
        return menu;
    }

    public static void main(String[] args) {
        try {
            Socket clientSocket = new Socket("localhost", 1234);

            BufferedReader in = new BufferedReader(new InputStreamReader(System.in));
            BufferedReader serverIn = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
            PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
            String userInput;
            System.out.println("Use 'login <username> <password>' to login");
            
            while ((userInput = in.readLine()) != null) {
                out.println(userInput);
                String serverResponse = serverIn.readLine();
                
                if (serverResponse.equals("login failed")) {
                    System.out.println("Server response: " + serverResponse + "!. Try again or Use 'forgotPassword <member ID> <phone number>' to recover your password");
                } else if (serverResponse.equals("Invalid command")) {
                    System.out.println("Server response: " + serverResponse + ". Kindly refer to command menu above");
                } else if (serverResponse.equals("No records found. Return after a day")) {
                    System.out.println(serverResponse); 
                } else if (serverResponse.startsWith("Application number:")) {
                    StringBuilder loanRecordResponse = new StringBuilder(serverResponse);
                    while ((serverResponse = serverIn.readLine()) != null && !serverResponse.isEmpty()) {
                        loanRecordResponse.append("\n").append(serverResponse);
                    }
                    System.out.println("Server response:\n" + loanRecordResponse.toString());
                   
                } else if (serverResponse.startsWith("Deposits")) {
                    StringBuilder checkstatement = new StringBuilder(serverResponse);
                    while ((serverResponse = serverIn.readLine()) != null && !serverResponse.isEmpty()) {
                        checkstatement.append("\n").append(serverResponse);
                    }
                    System.out.println(checkstatement.toString());
                    System.out.println(Client.displayMenu());
                } else if (serverResponse.startsWith("Congragulations your loan has been approved")) {
                    System.out.println(serverResponse);
                    String userResponse = in.readLine();
                  //  System.out.println("User Response: " + userResponse);
                    out.println(userResponse);

                   if (userResponse.equalsIgnoreCase("accept")) {
                        StringBuilder loan_installment = new StringBuilder(serverResponse);
                        while ((serverResponse = serverIn.readLine()) !=null && !serverResponse.isEmpty()){
                        loan_installment.append("\n").append(serverResponse);
                    }
                   System.out.println("Server response:\n" + loan_installment.toString());
                          
                } else {
                    System.out.println("Server response: " + serverResponse);
                    System.out.println(Client.displayMenu());
                }
            }
                System.out.println(serverResponse);
                System.out.println(Client.displayMenu());
            }

            in.close();
            serverIn.close();
            out.close();
            clientSocket.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
