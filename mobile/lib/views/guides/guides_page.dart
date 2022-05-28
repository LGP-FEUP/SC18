import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:erasmus_helper/views/guides/administration_tab.dart';
import 'package:erasmus_helper/views/guides/university_tab.dart';
import 'package:flutter/material.dart';

// TODO : replace this page with the good content
class GuidesPage extends StatelessWidget {
  const GuidesPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
        length: 2,
        child: AppTopBar(
          body: const TabBarView(
            children: [AdministrationTab(), UniversityTab()],
          ),
          title: "Guides",
          bottom: TabBar(
              indicatorColor: Theme.of(context).primaryColor,
              indicatorWeight: 2.5,
              labelColor: Theme.of(context).primaryColor,
              labelStyle: const TextStyle(fontSize: 16),
              tabs: const [
                Tab(
                  text: "Administration",
                ),
                Tab(
                  text: "University",
                )
              ]),
        ));
  }
}
