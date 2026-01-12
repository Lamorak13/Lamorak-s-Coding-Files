/*
 AUTHOR Lamorak13
 DATE STARTED: 4/15/2025
 DATE COMPILED: 4/15/2025
 DESCRIPTION: Java JPasswordField showcase, but this time modified with a JCheckBox w ActionListener for toggle password transparency
 */

import java.awt.Color;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.ImageIcon;
import javax.swing.JCheckBox;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPasswordField;
import javax.swing.JTextField;


public class NullLayout extends JFrame implements ActionListener{ //extends JFrame allows for superclass
    JLabel logoLabel = new JLabel(new ImageIcon("lockk.png")); // Middle of screen picture, Label
    JLabel usernameLabel = new JLabel("Username : ");
    JLabel passwordLabel = new JLabel("Password : ");
    JLabel errorLabel = new JLabel("Enter Valid Username and Password");

    JTextField usernameField = new JTextField(10); //String of username
    JPasswordField passwordField = new JPasswordField(); //Main topic point, hides input into censor dots
    JCheckBox showPasswordCheckBox = new JCheckBox("Show Password"); //Sets the visiblity toggle


        public static void main(String[] args) {
            new NullLayout();
        }
        public NullLayout(){
            setLayout(null); //customize layout, not predefined by system, needs ff. codes
            add(logoLabel); //these can go in any order apparently
            add(usernameLabel);
            add(passwordLabel);
            add(errorLabel);
            add(usernameField);
            add(passwordField);
            add(showPasswordCheckBox);

            //order does not matter again for here, arranging GUI components
            logoLabel.setBounds(150,1,200,190); //(THIS IS THE PICTURE) x,y,w,h, applies to ff. codes
            usernameLabel.setBounds(20,200,250,30); 
            passwordLabel.setBounds(20,250,250,30);
            errorLabel.setBounds(70,300,400,30);
            usernameField.setBounds(200,200,250,30);
            passwordField.setBounds(200,250,250,30);
            showPasswordCheckBox.setBounds(90,325,230,25);


            //customize the fonts used
            usernameLabel.setFont(new Font("Arial",Font.BOLD,20)); //From Tahoma to Arial customized
            passwordLabel.setFont(new Font("Arial",Font.BOLD,20));
            errorLabel.setFont(new Font("Arial",Font.BOLD,20));
            usernameField.setFont(new Font("Arial",Font.BOLD,20));
            passwordField.setFont(new Font("Arial",Font.BOLD,20));
            showPasswordCheckBox.setFont(new Font("Arial",Font.BOLD,20));

            errorLabel.setForeground(Color.red);//Makes errorLabel red font

            passwordField.addActionListener(this); // 'Listens' for the time Enter key is pressed for the ActionListener


            //Allows the toggle to work, the main process of it (Made possible by setEchoChar 0)
            showPasswordCheckBox.addActionListener(new ActionListener() { 
                public void actionPerformed(ActionEvent e) {
                    if (showPasswordCheckBox.isSelected()) {
                        passwordField.setEchoChar((char) 0);  // Show the password
                    } else {
                        passwordField.setEchoChar('*');  // Hide the password with the default '*' again
                    }
                }
            });


            // Window or JFrame aspects
            setTitle("Login");
            setResizable(false);
            setLocation(1000,100); // x and then y
            setIconImage(new ImageIcon("lock2.png").getImage());
            setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
            setSize(500,400);
            setVisible(true);

        }

        // For the override in ActionListener, this is the main PROCESS being done
        public void actionPerformed(ActionEvent e) {
            String username = usernameField.getText();
            String password = String.valueOf(passwordField.getPassword()); //Can also use getText but outdated
        

            if(username.equals("admin")){ //can also use IgnoreCase for non-case sensitive
                if(password.equals("12345")){
                    errorLabel.setText("Welcome, Admin!");
                    errorLabel.setForeground(Color.green);
                    logoLabel.setIcon(new ImageIcon("congrats.png"));
                    //dispose() can be used here, to clear; 
                }
                else{
                    errorLabel.setText("Invalid Password!");
                }
            }
            else if(password.equals("12345")){
                errorLabel.setText("Invalid Username!");
            }
            else {
                errorLabel.setText("Invalid Username and Password!");
            }


        }

    }