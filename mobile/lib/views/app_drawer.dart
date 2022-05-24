import 'package:erasmus_helper/views/profile/profile_screen.dart';
import 'package:erasmus_helper/views/settings/help_page.dart';
import 'package:erasmus_helper/views/settings/settings_page.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../services/authentication_service.dart';
import 'authentication/login.dart';

/// App generic drawer, to show the application settings
class AppDrawer extends StatelessWidget {
  const AppDrawer({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          const DrawerHeader(
            child: Text("Erasmus Helper"),
          ),
          ListTile(
            title: const Text("Profile"),
            leading: const Icon(Icons.person),
            onTap: () {
              Navigator.push(context,
                  MaterialPageRoute(builder: (context) => const ProfileScreen()));
            },
          ),
          ListTile(
            title: const Text("Settings"),
            leading: const Icon(Icons.settings),
            onTap: () {
              Navigator.push(
                  context,
                  MaterialPageRoute(
                      builder: (context) => const SettingsPage()));
            },
          ),
          ListTile(
            title: const Text("Help"),
            leading: const Icon(Icons.help),
            onTap: () {
              Navigator.push(context,
                  MaterialPageRoute(builder: (context) => const HelpPage()));
            },
          ),
          ListTile(
              title: const Text("Logout"),
              onTap: () => signOut(context),
              leading: const Icon(Icons.logout))
        ],
      ),
    );
  }

  void signOut(BuildContext context) {
    context.read<AuthenticationService>().signOut().then((value) =>
        Navigator.push(context,
            MaterialPageRoute(builder: (context) => const LoginPage())));
  }
}
