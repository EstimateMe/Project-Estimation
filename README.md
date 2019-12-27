# This repository contains the code for a simple Project Estimation System.

## To clone the repository to your local machine:
Prerequisite - git installed;
You could use the terminal itself or any GUI such as [gitkraken](https://www.gitkraken.com/) or [sourcetree](https://www.sourcetreeapp.com/)
- For Windows users using the terminal:
    1. Open the folder where you would like to clone the repo
    2. Type cmd in the path field
    3. The terminal should open and then type git clone https://github.com/EstimateMe/Project-Estimation.git
    
### Useful git command when using the termial: 
* **git checkout -b branchName** *Creates a branch with branchName and switches to it*
* **git commit -a -m "the message"** *Creates a commit with all the changes and a commit message*
* **git commit -o path/to/myfile -m "the message"** *Example for creation of a commit with only the file 'myfile' and a commit message*
* **git push** *Pushes the local commits to the remote repository; the first time you perform this you will need to type* **git push --set-upstream origin branchName**
* **git pull** *Pulls the latest changes from the remote repository for the current checkout branch*
* To **merge** your **branch-A to** the latest version **branch-B** and push it to remote:
     1. git checkout branch-B 
     2. git pull 
     3. git checkout branch-A 
     4. git merge branch-B
     5. git push
