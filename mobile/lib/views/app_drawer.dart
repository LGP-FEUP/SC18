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
          const SizedBox(
            height: 100,
            child: DrawerHeader(
                child: Image(image: AssetImage('assets/logo_complex.png'))),
          ),
          _genDrawerTile("Profile", Icons.person, () {
            Navigator.push(context,
                MaterialPageRoute(builder: (context) => const ProfileScreen()));
          }),
          _genDrawerTile("Settings", Icons.settings, () {
            Navigator.push(context,
                MaterialPageRoute(builder: (context) => const SettingsPage()));
          }),
          _genDrawerTile("Help", Icons.help, () {
            Navigator.push(context,
                MaterialPageRoute(builder: (context) => const HelpPage()));
          }),
          _genDrawerTile("Logout", Icons.logout, () => signOut(context)),
        ],
      ),
    );
  }
}

ListTile _genDrawerTile(String title, IconData icon, VoidCallback onTap) {
  return ListTile(
    iconColor: const Color(0xFF0038FF),
    title: Text(
      title,
      style: const TextStyle(fontSize: 16),
    ),
    leading: Icon(
      icon,
      size: 28,
    ),
    onTap: onTap,
  );
}

void signOut(BuildContext context) {
  context.read<AuthenticationService>().signOut().then((value) =>
      Navigator.push(
          context, MaterialPageRoute(builder: (context) => const LoginPage())));
}
