import 'package:erasmus_helper/views/app_drawer.dart';
import 'package:erasmus_helper/views/profile/profile_screen.dart';
import 'package:flutter/material.dart';

/// A application generic TopBar widget, from which you can change the title,
/// and the bottom (for tabs). It comes with a drawer but it can be switched for
/// a back button (in the case of settings pages for example).
class AppTopBar extends StatelessWidget {
  final Widget body;
  final PreferredSizeWidget? bottom;
  final String title;
  final bool activateBackButton;
  final FloatingActionButton? floatingButton;

  const AppTopBar({Key? key,
    required this.body,
    this.title = "Erasmus Helper",
    this.bottom,
    this.floatingButton,
    this.activateBackButton = false})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    Widget? drawer;
    if (!activateBackButton) {
      drawer = const AppDrawer();
    }
    return SafeArea(
        child: Scaffold(
          floatingActionButton: floatingButton,
          appBar: AppBar(
            automaticallyImplyLeading: true,
            foregroundColor: Theme
                .of(context)
                .primaryColor,
            backgroundColor: Colors.white,
            title: Text(title),
            bottom: bottom,
            actions: [
              // TODO : change with avatar of the account
              GestureDetector(
                  child: const CircleAvatar(
                    backgroundImage: AssetImage("assets/avatar.jpg"),
                  ),
                  onTap: () =>
                      Navigator.push(context,
                          MaterialPageRoute(
                              builder: (context) => const ProfileScreen()))),
              // TODO : add notification system
              IconButton(
                  onPressed: () {}, icon: const Icon(Icons.notifications))
            ],
          ),
          drawer: drawer,
          body: body,
        ));
  }
}
