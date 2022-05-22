import 'package:erasmus_helper/services/group_service.dart';
import 'package:flutter/material.dart';

class GroupCard extends StatelessWidget {
  final String groupId;

  const GroupCard({Key? key, required this.groupId}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: GroupService.getGroupImage(groupId),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            return Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  height: 200,
                  width: 300,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(10),
                    image: DecorationImage(
                      fit: BoxFit.fill,
                      image: NetworkImage(
                        response.data as String,
                      ),
                    ),
                  ),
                ),
                Row(
                  children: [
                    FutureBuilder(
                      future: GroupService.getGroupTitle(groupId),
                      builder: (context, response) {
                        if (response.connectionState == ConnectionState.done) {
                          if (response.data != null) {
                            return Text(
                              response.data.toString(),
                              style: const TextStyle(fontSize: 20),
                            );
                          }
                        }
                        return Container();
                      },
                    )
                  ],
                )
              ],
            );
          }
        }
        return Container();
      },
    );
  }
}
